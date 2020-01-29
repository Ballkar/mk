<?php

namespace App\Policies\Announcement;

use App\Http\Controllers\Constants\Roles;
use App\Models\Announcement\Announcement;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any announcements.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the announcement.
     *
     * @param User $user
     * @param Announcement $announcement
     * @return mixed
     */
    public function view(?User $user, Announcement $announcement)
    {
        if($announcement->is_active || $user->id === $announcement->owner_id) {
            return Response::allow();
        } else {
            return Response::deny();
        }
    }

    /**
     * Determine whether the user can create announcements.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->role_id === Roles::ROLE_USER) {
            return Response::allow();
        } else {
            return Response::deny();
        }
    }

    /**
     * Determine whether the user can update the announcement.
     *
     * @param User $user
     * @param Announcement $announcement
     * @return mixed
     */
    public function update(User $user, Announcement $announcement)
    {
        if($user->id === $announcement->owner_id) {
            return Response::allow();
        } else {
            return Response::deny();
        }
    }

    /**
     * Determine whether the user can delete the announcement.
     *
     * @param User $user
     * @param Announcement $announcement
     * @return mixed
     */
    public function delete(User $user, Announcement $announcement)
    {
        if($user->id === $announcement->owner_id) {
            return Response::allow();
        } else {
            return Response::deny();
        }
    }

    /**
     * Determine whether the user can restore the announcement.
     *
     * @param User $user
     * @param Announcement $announcement
     * @return mixed
     */
    public function restore(User $user, Announcement $announcement)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the announcement.
     *
     * @param User $user
     * @param Announcement $announcement
     * @return mixed
     */
    public function forceDelete(User $user, Announcement $announcement)
    {
        return Response::allow();
    }
}