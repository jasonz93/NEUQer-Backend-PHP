<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:33
 */

namespace NEUQer\SDK\Weixin;


class ErrorCode
{
    const OK = 0;
    const VALIDATE_SIGNATURE_ERROR = -40001;
    const PARSE_XML_ERROR = -40002;
    const COMPUTE_SIGNATURE_ERROR = -40003;
    const ILLEGAL_AES_KEY = -40004;
    const VALIDATE_APP_ID_ERROR = -40005;
    const ENCRYPT_AES_ERROR = -40006;
    const DECRYPT_AES_ERROR = -40007;
    const ILLEGAL_BUFFER = -40008;
    const ENCODE_BASE64_ERROR = -40009;
    const DECODE_BASE64_ERROR = -40010;
    const GEN_RETURN_XML_ERROR = -40011;
}