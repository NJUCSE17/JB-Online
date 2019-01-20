<?php

/**
 * @OA\Info(
 *      version="v1",
 *      title="JB Online API Documentation",
 *      description="JB Online OpenApi description",
 *     @OA\License(
 *         name="MIT License",
 *         url="https://github.com/NJUCSE17/JB-Online"
 *     )
 * )
 */

class OAuth2API
{
    /**
     * @OA\Get(
     *     path="/oauth/clients",
     *     tags={"OAuth2"},
     *     summary="Get the list of clients of current user.",
     *     security={{"passport" : {}}},
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JSONContent(type="array", items=@OA\Property(ref="#/components/schemas/ClientInfo"))
     *     )
     * )
     */

    /**
     * @OA\Post(
     *     path="/oauth/clients",
     *     tags={"OAuth2"},
     *     summary="Create a new OAuth2 authorization code grant type client.",
     *     security={{"passport" : {}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name", type="string",
     *                      description="Name of the client."
     *                  ),
     *                  @OA\Property(
     *                      property="redirect", type="string",
     *                      description="Redirect URI of the client."
     *                  ),
     *                  required={"name", "redirect"}
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JSONContent(ref="#/components/schemas/ClientInfo"),
     *     ),
     * )
     */

    /**
     * @OA\Put(
     *     path="/oauth/clients/{client-id}",
     *     tags={"OAuth2"},
     *     summary="Update an OAuth2 client.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="client-id",
     *         description="Numeric ID of the client.",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name", type="string",
     *                      description="Name of the client."
     *                  ),
     *                  @OA\Property(
     *                      property="redirect", type="string",
     *                      description="Redirect URI of the client."
     *                  ),
     *                  required={"name", "redirect"}
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JSONContent(ref="#/components/schemas/ClientInfo"),
     *     ),
     * )
     */

    /**
     * @OA\Delete(
     *     path="/oauth/clients/{client-id}",
     *     tags={"OAuth2"},
     *     summary="Delete an OAuth2 client.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="client-id",
     *         description="Numeric ID of the client.",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     * )
     */

    /**
     * @OA\Get(
     *     path="/oauth/authorize",
     *     tags={"OAuth2"},
     *     summary="Compose an OAuth2 authorization request and get authorization code.",
     *     @OA\Parameter(
     *         name="client_id",
     *         description="Numeric ID of the client.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="redirect_uri",
     *         description="Redirect URI of the client.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="response_type",
     *         description="Response type of the request.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="string", enum={"code"})
     *     ),
     *     @OA\Parameter(
     *         name="scope",
     *         description="Scope requested, (there is no scope registered in JB Online).",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="string", enum={""})
     *     ),
     *     @OA\Response(response=401, description="Client authorization failure"),
     *     @OA\Response(response=200, description="Authorization page"),
     *     @OA\Response(response=302, description="Succeed and redirect to callback page"),
     * )
     */

    /**
     * @OA\Post(
     *     path="/oauth/token",
     *     tags={"OAuth2"},
     *     summary="Request for an access token with one-time authorization code.",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/AccessRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful access request",
     *          @OA\JSONContent(ref="#/components/schemas/AccessSuccessfulResponse")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Unsuccessful access request",
     *          @OA\JSONContent(ref="#/components/schemas/AccessUnsuccessfulResponse")
     *     ),
     * )
     */
}

/**
 * @OA\Schema()
 */
class ClientInfo
{
    /**
     * Numeric ID of the client.
     *
     * @var integer
     * @OA\Property()
     */
    public $id;

    /**
     * Numeric ID of the issuer of the client.
     *
     * @var integer
     * @OA\Property()
     */
    public $user_id;

    /**
     * Name of the client.
     *
     * @var string
     * @OA\Property()
     */
    public $name;

    /**
     * Secret token of the client.
     * @var string
     * @OA\Property()
     */
    public $secret;

    /**
     * Redirect URI of the client.
     * @var string
     * @OA\Property()
     */
    public $redirect;

    /**
     * Whether this is a personal access type client.
     * @var boolean
     * @OA\Property()
     */
    public $personal_access_client;

    /**
     * Whether this is a password grant type client.
     * @var boolean
     * @OA\Property()
     */
    public $password_client;

    /**
     * Whether this client is revoked.
     * @var boolean
     * @OA\Property()
     */
    public $revoked;

    /**
     * Timestamp of the created time of the client.
     * @var string
     * @OA\Property()
     */
    public $created_at;

    /**
     * Timestamp of the last updated time of the client.
     * @var string
     * @OA\Property()
     */
    public $updated_at;
}

/**
 * @OA\Schema(required={"grant_type", "client_id", "client_secret"})
 */
class AccessRequest
{
    /**
     * OAuth2 Grant Type
     * @var string
     * @OA\Property()
     */
    public $grant_type;

    /**
     * OAuth2 Client ID
     * @var string
     * @OA\Property()
     */
    public $client_id;

    /**
     * OAuth2 Client Secret
     * @var string
     * @OA\Property()
     */
    public $client_secret;

    /**
     * OAuth2 Scope Requested (leave it empty)
     * @var string
     * @OA\Property()
     */
    public $scope;

    /**
     * (Authorization Code Grant Type) OAuth2 Redirect URI
     * @var string
     * @OA\Property()
     */
    public $redirect_uri;

    /**
     * (Authorization Code Grant Type) OAuth2 Authorization Code
     * @var string
     * @OA\Property()
     */
    public $code;

    /**
     * (Password Grant Type) Username
     * @var string
     * @OA\Property()
     */
    public $username;

    /**
     * (Password Grant Type) Password
     * @var string
     * @OA\Property()
     */
    public $password;
}

/**
 * @OA\Schema()
 */
class AccessSuccessfulResponse
{
    /**
     * Access token.
     *
     * @var string
     * @OA\Property()
     */
    public $access_token;

    /**
     * Type of the token.
     *
     * @var string
     * @OA\Property()
     */
    public $token_type;

    /**
     * Time before the token expires.
     *
     * @var string
     * @OA\Property()
     */
    public $expires_in;

    /**
     * Refresh token.
     *
     * @var string
     * @OA\Property()
     */
    public $refresh_token;

    /**
     * Scopes of the token.
     *
     * @var string
     * @OA\Property()
     */
    public $scope;
}

/**
 * @OA\Schema()
 */
class AccessUnsuccessfulResponse
{
    /**
     * Error type.
     *
     * @var string
     * @OA\Property()
     */
    public $error;

    /**
     * Error message.
     *
     * @var string
     * @OA\Property()
     */
    public $message;

    /**
     * Hint to solve the error.
     *
     * @var string
     * @OA\Property()
     */
    public $hint;
}