<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

/**
 * Copy-paste this file to your config/autoload folder (don't forget to remove the .
 * dist extension!)
 */
return [
    'zfc_rbac' => [
        'identity_provider' => 'DotUser\Rbac\IdentityProvider',
        'guest_role' => 'guest',
        'guards' => [],
        'rest_guards' => [
            'UserApi\V1\Rest\User\\Controller' => [
                'entity' => [
                    'GET' => ['get_user'],
                    'POST' => false,
                    'PATCH' => ['edit_user'],
                    'PUT' => ['edit_user'],
                    'DELETE' => ['delete_user'],
                ],
                'collection' => [
                    'GET' => ['get_users'],
                    'POST' => ['create_user'],
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ],
            ],
            'MailApi\\V1\\Rpc\\Send\\Controller' => [
                'send' => [
                    'GET' => false,
                    'POST' => ['send_email'],
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ],
            ],
        ],
        'protection_policy' => \ZfcRbac\Guard\GuardInterface::POLICY_ALLOW,
        
        'role_provider' => [
            'DotUser\Rbac\DbRoleProvider' => [],
        ],
        'role_provider_manager' => [
            'factories' => [
                'DotUser\Rbac\DbRoleProvider' => 'DotUser\Rbac\DbRoleProviderFactory'
            ],
        ],
    ],
];
    
