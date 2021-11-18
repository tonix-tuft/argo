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

namespace Argo;

use Argo\HasherInterface;
use Tonix\PHPUtils\RandUtils;

/**
 * Argo's hasher.
 *
 * @author Anton Bagdatyev (Tonix) <antonytuft@gmail.com>
 */
class Hasher implements HasherInterface {
  /**
   * Default minimum length of the secret salt.
   */
  const DEFAULT_SALT_MIN_LENGTH = 32;

  /**
   * Default maximum length of the secret salt.
   */
  const DEFAULT_SALT_MAX_LENGTH = 255;

  /**
   * PASSWORD_ARGON2I|PASSWORD_ARGON2ID
   *
   * @var int
   */
  protected $algo;

  /**
   * Constructs a new hasher.
   *
   * @param string $version The PHP version (defaults to `PHP_VERSION`).
   */
  public function __construct($version = PHP_VERSION) {
    $this->algo =
      version_compare($version, '7.3.0') >= 0
        ? PASSWORD_ARGON2ID
        : PASSWORD_ARGON2I;
  }

  /**
   * {@inheritdoc}
   */
  public function hash($str, $params) {
    [
      'pepper' => $pepper,
      'saltMinLength' => $saltMinLength,
      'saltMaxLength' => $saltMaxLength,
    ] = $params + [
      'saltMinLength' => self::DEFAULT_SALT_MIN_LENGTH,
      'saltMaxLength' => self::DEFAULT_SALT_MAX_LENGTH,
    ];

    $salt = RandUtils::generateRandomStr(
      random_int($saltMinLength, $saltMaxLength)
    );

    $seasoned = $salt . $str . $pepper;
    $hash = password_hash($seasoned, $this->algo);

    return [
      'hash' => $hash,
      'salt' => $salt,
      'pepper' => $pepper,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function verify($str, $params) {
    [
      'hash' => $hash,
      'salt' => $salt,
      'pepper' => $pepper,
    ] = $params;

    $seasoned = $salt . $str . $pepper;

    return password_verify($seasoned, $hash);
  }
}
