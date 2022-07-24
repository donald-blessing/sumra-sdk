<?php

namespace Sumra\SDK\Services;

use App\Models\User;
use Exception;
use Sumra\SDK\Enums\ServicesEnums;

class AdminManager
{
    /**
     * @param array $request
     *
     * @return void
     * @throws Exception
     */
    public function addAdmin(array $request): void
    {
        // Retrieve the validated input...
        $validated = $request;

        $admin = User::find($validated['user_id']);
        if (empty($admin)) {
            throw new Exception('User does not exist');
        }

        PubSub::transaction(function () use ($validated, &$admin) {

        })->publish('AdminManagerEvent', [
            'admin' => $admin,
            'role' => $validated['role'],
            'service' => $validated['service'],
            'action' => 'store',
        ], 'service_admin');
    }

    /**
     * @param array $request
     *
     * @return void
     * @throws Exception
     */
    public function updateAdmin(array $request): void
    {
        // Retrieve the validated input...
        $validated = $request;

        $admin = User::find($validated['user_id']);
        if (empty($admin)) {
            throw new Exception('User does not exist');
        }

        PubSub::transaction(function () {

        })->publish('AdminManagerEvent', [
            'admin' => $admin,
            'role' => $validated['role'],
            'service' => $validated['service'],
            'action' => 'update',
        ], 'service_admin');
    }

    /**
     * @param array $request
     *
     * @return void
     * @throws Exception
     */
    public function removeAdmin(array $request): void
    {
        // Retrieve the validated input...
        $validated = $request;

        $admin = User::find($validated['user_id']);
        if (empty($admin)) {
            throw new Exception('User does not exist');
        }

        PubSub::transaction(function () {

        })->publish('AdminManagerEvent', [
            'admin' => $admin,
            'service' => $validated['service'],
            'action' => 'delete',
        ], 'service_admin');
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return ServicesEnums::getServices();
    }
}