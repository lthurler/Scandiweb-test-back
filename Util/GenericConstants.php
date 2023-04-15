<?php

namespace Util;

abstract class GenericConstants
{
    /* REQUESTS */
    public const ROUTES = ['product'];
    public const RESOURCES = ['add', 'list','delete'];      
    public const METHODS = ['GET', 'POST', 'UPDATE'];

    /* ERRORS */
    public const ERROR_MSG_ROUTE = 'Route not allowed!';
    public const ERROR_MSG_NON_EXISTENT_RESOURCE = 'Resource does not exist!';
    public const ERROR_MSG_GENERIC = 'Some error occurred in the request!';
    public const ERROR_MSG_NO_RETURN = 'No record found!';
    public const ERROR_MSG_NOT_AFFECTED = 'No record affected!';
    public const ERROR_MSG_TOKEN_NOT_AUTHORIZED = 'Token not authorized!';
    public const ERR0R_MSG_EMPTY_JSON = 'Request Body cannot be empty!';
    public const ERROR_MSG_ID_REQUIRED = 'ID is required!';
    public const TYPE_ERROR = 'error';

    /* SUCESS */
    public const MSG_SUCCESS_DELETED = 'Record successfully deleted!';
    public const MSG_SUCCESS_ADD = 'Record successfully added!';
    public const TYPE_SUCESS = 'sucess';    

    /* OTHERS */
    public const YES = 'Y';
    public const TYPE = 'type';
    public const RESPONSE = 'response';
}
