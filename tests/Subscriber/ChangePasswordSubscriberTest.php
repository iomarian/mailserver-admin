<?php

declare(strict_types=1);
/**
 * This file is part of the mailserver-admin package.
 * (c) Jeffrey Boehm <https://github.com/jeboehm/mailserver-admin>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Subscriber;

use App\Entity\User;
use App\Service\PasswordService;
use App\Subscriber\ChangePasswordSubscriber;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

class ChangePasswordSubscriberTest extends TestCase
{
    public function testPasswordGetsUpdatedOnPreUpdate(): void
    {
        $eventDispatcher = new EventDispatcher();
        $passwordService = $this->createMock(PasswordService::class);
        $passwordService->expects($this->once())->method('processUserPassword');

        $eventDispatcher->addSubscriber(new ChangePasswordSubscriber($passwordService));
        $eventDispatcher->dispatch(new GenericEvent(new User()), EasyAdminEvents::PRE_UPDATE);
        $eventDispatcher->dispatch(new GenericEvent(new stdClass()), EasyAdminEvents::PRE_UPDATE);
    }

    public function testPasswordGetsUpdatedOnPrePersist(): void
    {
        $eventDispatcher = new EventDispatcher();
        $passwordService = $this->createMock(PasswordService::class);
        $passwordService->expects($this->once())->method('processUserPassword');

        $eventDispatcher->addSubscriber(new ChangePasswordSubscriber($passwordService));
        $eventDispatcher->dispatch(new GenericEvent(new User()), EasyAdminEvents::PRE_PERSIST);
        $eventDispatcher->dispatch(new GenericEvent(new stdClass()), EasyAdminEvents::PRE_PERSIST);
    }
}
