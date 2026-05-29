<?php declare(strict_types=1);

namespace App\Core;

/**
 * Enum contendo os principais métodos HTTP para
 * a construção desta API REST.
 */
enum HttpMethod: string
{
    case GET = "GET";
    case PATCH = "PATCH";
    case POST = "POST";
    case PUT = "PUT";
    case DELETE = "DELETE";
    case OPTIONS = "OPTIONS";
}