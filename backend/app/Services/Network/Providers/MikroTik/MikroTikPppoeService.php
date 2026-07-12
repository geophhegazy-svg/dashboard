<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use App\Exceptions\Network\ResourceNotFoundException;
use App\Contracts\Network\Services\PppoeServiceInterface;
use Illuminate\Support\Facades\Log;
use RouterOS\Query;


class MikroTikPppoeService
{
    public function __construct(
        protected MikroTikQueryService $query
    ) {
    }


    /**
     * Get all PPPoE users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getAllUsers(): array
    {
        return $this->query->execute(
            new Query('/ppp/secret/print')
        );
    }


    /**
     * Get specific PPPoE user.
     *
     * @return array<string,mixed>|null
     */
    public function getUser(
        string $username
    ): ?array {

        $query = (new Query('/ppp/secret/print'))
            ->where('name', $username);


        return $this->query->first($query);
    }


    /**
     * Create PPPoE user.
     *
     * @param array<string,mixed> $options
     */
    public function createUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {

        $query = (new Query('/ppp/secret/add'))
            ->equal('name', $username)
            ->equal('password', $password)
            ->equal('profile', $profile)
            ->equal('service', 'pppoe');


        if (isset($options['comment'])) {

            $query->equal(
                'comment',
                $options['comment']
            );
        }


        if (isset($options['local_address'])) {

            $query->equal(
                'local-address',
                $options['local_address']
            );
        }


        if (isset($options['remote_address'])) {

            $query->equal(
                'remote-address',
                $options['remote_address']
            );
        }


        return $this->query->write($query);
    }


    /**
     * Update PPPoE user password/profile.
     *
     * @param array<string,mixed> $data
     */
    public function updateUser(
        string $username,
        array $data
    ): bool {

        $user = $this->getUser($username);


        if ($user === null) {

            throw ResourceNotFoundException::missing(
                'pppoe-user',
                [
                    'username' => $username,
                ]
            );
        }


        $query = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id']);


        foreach ($data as $key => $value) {

            $query->equal(
                str_replace('_', '-', $key),
                $value
            );
        }


        return $this->query->write($query);
    }

    /**
     * Disable PPPoE user.
     */
    public function disableUser(
        string $username
    ): bool {

        return $this->setUserDisabled(
            $username,
            true
        );
    }



    /**
     * Enable PPPoE user.
     */
    public function enableUser(
        string $username
    ): bool {

        return $this->setUserDisabled(
            $username,
            false
        );
    }



    /**
     * Change PPPoE user disabled state.
     */
    protected function setUserDisabled(
        string $username,
        bool $disabled
    ): bool {

        $user = $this->getUser($username);


        if ($user === null) {

            throw ResourceNotFoundException::missing(
                'pppoe-user',
                [
                    'username' => $username,
                ]
            );
        }


        $query = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id'])
            ->equal(
                'disabled',
                $disabled ? 'yes' : 'no'
            );


        return $this->query->write($query);
    }



    /**
     * Delete PPPoE user.
     */
    public function deleteUser(
        string $username
    ): bool {

        $user = $this->getUser($username);


        if ($user === null) {

            throw ResourceNotFoundException::missing(
                'pppoe-user',
                [
                    'username' => $username,
                ]
            );
        }


        $query = (new Query('/ppp/secret/remove'))
            ->equal('.id', $user['.id']);


        return $this->query->write($query);
    }



    /**
     * Get active PPPoE sessions.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getActiveSessions(): array
    {
        return $this->query->execute(
            new Query('/ppp/active/print')
        );
    }



    /**
     * Get active session by username.
     *
     * @return array<string,mixed>|null
     */
    public function getActiveSession(
        string $username
    ): ?array {

        $query = (new Query('/ppp/active/print'))
            ->where('name', $username);


        return $this->query->first($query);
    }

    /**
     * Disconnect active PPPoE session.
     */
    public function disconnectUser(
        string $username
    ): bool {

        $session = $this->getActiveSession($username);


        if ($session === null) {

            Log::info(
                'No active PPPoE session found',
                [
                    'username' => $username,
                ]
            );

            return false;
        }


        $query = (new Query('/ppp/active/remove'))
            ->equal('.id', $session['.id']);


        return $this->query->write($query);
    }



    /**
     * Change PPPoE user profile.
     */
    public function updateProfile(
        string $username,
        string $profile
    ): bool {

        return $this->updateUser(
            $username,
            [
                'profile' => $profile,
            ]
        );
    }



    /**
     * Update PPPoE password.
     */
    public function updatePassword(
        string $username,
        string $password
    ): bool {

        return $this->updateUser(
            $username,
            [
                'password' => $password,
            ]
        );
    }



    /**
     * Search PPPoE users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function searchUsers(
        string $keyword
    ): array {

        $users = $this->getAllUsers();


        return array_values(
            array_filter(
                $users,
                function ($user) use ($keyword) {

                    return isset($user['name'])
                        && str_contains(
                            strtolower($user['name']),
                            strtolower($keyword)
                        );
                }
            )
        );
    }



    /**
     * Get user status.
     *
     * @return array<string,mixed>
     */
    public function status(
        string $username
    ): array {

        $user = $this->getUser($username);

        $session = $this->getActiveSession($username);


        return [
            'username' => $username,
            'exists' => $user !== null,
            'online' => $session !== null,
            'session' => $session,
            'user' => $user,
        ];
    }
}
