<?php

namespace App\Policies;

use App\Models\Truck;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TruckPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if ($user->isGranted(User::ROLE_SUPERADMIN)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    public function viewTrucksWithDrivers(User $user)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    public function viewTrucksWithoutDrivers(User $user)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    public function viewTrucksWorking(User $user)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    public function viewTrucksNoWorking(User $user)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    public function viewTruckComplaints(User $user)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    public function viewTrucksNeighborhood(User $user)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Truck  $truck
     * @return mixed
     */
    public function view(User $user, Truck $truck)
    {
        //
        return $user->isGranted(User::ROLE_DRIVER) && $user->id === $truck->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Truck  $truck
     * @return mixed
     */
    public function update(User $user, Truck $truck)
    {
        //
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Truck  $truck
     * @return mixed
     */
    public function delete(User $user, Truck $truck)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Truck  $truck
     * @return mixed
     */
    public function restore(User $user, Truck $truck)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Truck  $truck
     * @return mixed
     */
    public function forceDelete(User $user, Truck $truck)
    {
        //
    }
}
