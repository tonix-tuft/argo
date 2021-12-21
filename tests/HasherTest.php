<?php

/*
 * Copyright (c) 2021 Anton Bagdatyev (Tonix)
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

use PHPUnit\Framework\TestCase;
use Argo\Password;

/**
 * @author Anton Bagdatyev (Tonix) <antonytuft@gmail.com>
 */
class HasherTest extends TestCase {
  public function test hashing and verifying a password works() {
    $passwordStr = '@bc$ldAlW_0-3989mld';
    $pepper = 'y7Bz2wutmN6fBBELEAllkICfRhK3j1Tj';
    $password = new Password();
    $hashRes = $password->hash($passwordStr, [
      'pepper' => $pepper,
    ]);
    $verified = $password->verify($passwordStr, $hashRes);

    $this->assertSame(true, $verified);
  }

  public function test hashing and verifying a password in PHP 7_2 works() {
    $passwordStr = '@bc$ldAlW_0-3989mld';
    $pepper = 'y7Bz2wutmN6fBBELEAllkICfRhK3j1Tj';
    $password = new Password('7.2.0');
    $hashRes = $password->hash($passwordStr, [
      'pepper' => $pepper,
    ]);
    $verified = $password->verify($passwordStr, $hashRes);

    $this->assertSame(true, $verified);
  }

  public function test two hashes of different passwords are different() {
    $pepper = 'y7Bz2wutmN6fBBELEAllkICfRhK3j1Tj';

    $passwordStr = '@bc$ldAlW_0-3989mld';
    $password = new Password();
    $hashRes = $password->hash($passwordStr, [
      'pepper' => $pepper,
    ]);
    $hash1 = $hashRes['hash'];

    $passwordStr = 'abcjlkdsa-021';
    $password = new Password();
    $hashRes = $password->hash($passwordStr, [
      'pepper' => $pepper,
    ]);
    $hash2 = $hashRes['hash'];

    $this->assertNotSame($hash1, $hash2);
  }

  public function test hashing a password in PHP 7_2 produces a different hash than hashing the same password in PHP version 7_3 and above() {
    $passwordStr = '@bc$ldAlW_0-3989mld';
    $pepper = 'y7Bz2wutmN6fBBELEAllkICfRhK3j1Tj';

    $password = new Password('7.2.0');
    $hashRes = $password->hash($passwordStr, [
      'pepper' => $pepper,
    ]);
    $hash7_2 = $hashRes['hash'];

    $password = new Password();
    $hashRes = $password->hash($passwordStr, [
      'pepper' => $pepper,
    ]);
    $hash7_3AndAbove = $hashRes['hash'];

    $this->assertNotSame($hash7_2, $hash7_3AndAbove);
  }
}
