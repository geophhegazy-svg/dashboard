<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use App\Exceptions\Network\ResourceNotFoundException;
use RouterOS\Query;

class MikroTikHotspotService
{
    public function __construct(
        protected MikroTikQueryService $query
    ) {
    }


    /**
     * Get all hotspot users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getUsers(): array
    {
        return $this->query->execute(
            new Query('/ip/hotspot/user/print')
        );
    }



    /**
     * Get hotspot user.
     *
     * @return array<string,mixed>|null
     */
    public function findUser(
        string $username
    ): ?array {

        $query = (new Query('/ip/hotspot/user/print'))
            ->where('name', $username);


        return $this->query->first($query);
    }



    /**
     * Get active hotspot sessions.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getActiveSessions(): array
    {
        return $this->query->execute(
            new Query('/ip/hotspot/active/print')
        );
    }



    /**
     * Get active session for user.
     *
     * @return array<string,mixed>|null
     */
    public function getActiveSession(
        string $username
    ): ?array {

        $query = (new Query('/ip/hotspot/active/print'))
            ->where('user', $username);


        return $this->query->first($query);
    }



    /**
     * Create hotspot user.
     *
     * @param array<string,mixed> $options
     */
    public function createUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {

        $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name', $username)
            ->equal('password', $password)
            ->equal('profile', $profile);



        if (isset($options['comment'])) {

            $query->equal(
                'comment',
                $options['comment']
            );
        }



        if (isset($options['limit_uptime'])) {

            $query->equal(
                'limit-uptime',
                $options['limit_uptime']
            );
        }



        if (isset($options['email'])) {

            $query->equal(
                'email',
                $options['email']
            );
        }



        return $this->query->write($query);
    }

    /**
     * Disable hotspot user.
     */
    public function disableUser(
        string $username
    ): bool {

        return $this->changeState(
            $username,
            true
        );
    }



    /**
     * Enable hotspot user.
     */
    public function enableUser(
        string $username
    ): bool {

        return $this->changeState(
            $username,
            false
        );
    }



    /**
     * Change hotspot user state.
     */
    protected function changeState(
        string $username,
        bool $disabled
    ): bool {

        $user = $this->findUser($username);


        if ($user === null) {

            throw ResourceNotFoundException::missing(
                'hotspot-user',
                [
                    'username' => $username,
                ]
            );
        }


        $query = (new Query('/ip/hotspot/user/set'))
            ->equal('.id', $user['.id'])
            ->equal(
                'disabled',
                $disabled ? 'yes' : 'no'
            );


        return $this->query->write($query);
    }



    /**
     * Delete hotspot user.
     */
    public function deleteUser(
        string $username
    ): bool {

        $user = $this->findUser($username);


        if ($user === null) {

            throw ResourceNotFoundException::missing(
                'hotspot-user',
                [
                    'username' => $username,
                ]
            );
        }


        $query = (new Query('/ip/hotspot/user/remove'))
            ->equal('.id', $user['.id']);


        return $this->query->write($query);
    }



    /**
     * Disconnect active hotspot session.
     */
    public function disconnectUser(
        string $username
    ): bool {

        $session = $this->getActiveSession($username);


        if ($session === null) {
            return false;
        }


        $query = (new Query('/ip/hotspot/active/remove'))
            ->equal('.id', $session['.id']);


        return $this->query->write($query);
    }



    /**
     * Get user status.
     *
     * @return array<string,mixed>
     */
    public function status(
        string $username
    ): array {

        $user = $this->findUser($username);

        $session = $this->getActiveSession($username);


        return [
            'username' => $username,
            'exists' => $user !== null,
            'online' => $session !== null,
            'user' => $user,
            'session' => $session,
        ];
    }

    /**
     * Update hotspot user.
     *
     * @param array<string,mixed> $data
     */
    public function updateUser(
        string $username,
        array $data
    ): bool {

        $user = $this->findUser($username);


        if ($user === null) {

            throw ResourceNotFoundException::missing(
                'hotspot-user',
                [
                    'username' => $username,
                ]
            );
        }


        $query = (new Query('/ip/hotspot/user/set'))
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
     * Update hotspot profile.
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
     * Update hotspot password.
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
     * Search hotspot users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array {

        $users = $this->getUsers();


        return array_values(
            array_filter(
                $users,
                function (array $user) use ($keyword) {

                    return isset($user['name'])
                        &&
                        str_contains(
                            strtolower($user['name']),
                            strtolower($keyword)
                        );
                }
            )
        );
    }



    /**
     * Get hotspot statistics.
     *
     * @return array<string,mixed>
     */
    public function statistics(): array
    {
        $users = $this->getUsers();

        $active = $this->getActiveSessions();


        return [
            'total_users' => count($users),
            'active_sessions' => count($active),
        ];
    }
}
