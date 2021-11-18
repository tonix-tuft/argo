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

/**
 * Argo's hasher interface.
 *
 * @author Anton Bagdatyev (Tonix) <antonytuft@gmail.com>
 */
interface HasherInterface {
  /**
   * Hashes a string.
   *
   * @param string $str The string to hash.
   * @param array $params An associative array of parameters:
   *
   *                          - 'pepper' (string): Secret pepper to use for hashing;
   *                          - 'saltMinLength' (int) optional: The secret random salt minimum length (optional, will default to some value);
   *                          - 'saltMaxLength' (int) optional: The secret random salt minimum length (optional, will default to some value);
   *
   * @return array An associative array with the following keys:
   *
   *                   - 'hash' (string): The hash of `$str`;
   *                   - 'salt' (string): The secret random salt used for hashing;
   *                   - 'pepper' (string): Secret pepper used for hashing (same string as the one given by the caller code in `$params`).
   *
   */
  public function hash($str, $params);

  /**
   * Verifies a string against a hash presumably previously returned by {@link HasherInterface::hash()}.
   *
   * @param string $str The string to verify.
   * @param array $params An associative array of parameters:
   *
   *                          - 'hash' (string): The hash to use to verify `$str`;
   *                          - 'salt' (string): The secret random salt used for hashing;
   *                          - 'pepper' (string): Secret pepper used for hashing (same string as the one returned by {@link HasherInterface::hash()}).
   *
   * @return bool TRUE if the string is verified against the given hash, FALSE otherwise.
   */
  public function verify($str, $params);
}
