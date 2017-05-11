<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Classes\PHGHClass;
use App\Classes\MicroPHGHClass;
use App\Classes\PAGBClass;
use App\Classes\PAGBFixClass;
use App\Classes\BlockioManualCallbackClass;
use App\Classes\PairClass;
use App\Classes\PHPlusClass; 
use App\Classes\UserClass;
use App\Classes\DemoClass;
use App\Classes\AdminClass;
use Carbon\Carbon;
use App\Model\helpdesk\Ticket\Tickets;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->everyFiveMinutes()
                 ->sendOutputTo('/var/www/html/storage/framework/logs/'. str_replace(" ","_",str_replace(":","-",Carbon::now())))
                 ->withoutOverlapping();

        $schedule->call(function () {
            $sys_status = env('SYS_STATUS', 0);
            $i = 0;


            if ($sys_status <= 2)
            {
                $i++;
                AdminClass::addCronLog('#' . $i . ' Manual Callback Start');
                BlockioManualCallbackClass::manual_callback();
                AdminClass::addCronLog('#' . $i . ' Manual Callback Finish');
            }

            if ($sys_status == 1)
            {
                $i++;
                AdminClass::addCronLog('#'.$i.' Recheck Callback Start');
                BlockioManualCallbackClass::recheckOnholdPHGH();
                AdminClass::addCronLog('#'.$i.' Recheck Callback Finish');
            	
                $i++;
                AdminClass::addCronLog('#'.$i.' PHGH Payment Start');
                PHGHClass::checkPHPaymentStatusAll();
                PHGHClass::checkGHPaymentStatusAll();
                PHGHClass::checkPHPaymentExpiredAll();
                AdminClass::addCronLog('#'.$i.' PHGH Payment Finish');
                $i++;
                AdminClass::addCronLog('#'.$i.' PHGH Match Start');
                PHGHClass::matchPHGH(50,1);
                PHGHClass::matchPHGH();
                AdminClass::addCronLog('#'.$i.' PHGH Match Finish');
                $i++;
                AdminClass::addCronLog('#'.$i.' PHGH Payment Start');
                PHGHClass::checkPHPaymentStatusAll();
                PHGHClass::checkGHPaymentStatusAll();
                PHGHClass::checkPHPaymentExpiredAll();
                AdminClass::addCronLog('#'.$i.' PHGH Payment Finish');

                $i++;
                AdminClass::addCronLog('#'.$i.' PH Plus Start');
                PHPlusClass::getPHPlus();
                AdminClass::addCronLog('#'.$i.' PH Plus Finish');

                $i++;
                AdminClass::addCronLog('#'.$i.' Micro PHGH Payment Start');
                MicroPHGHClass::checkPHPaymentStatusAll();
                MicroPHGHClass::checkGHPaymentStatusAll();
                MicroPHGHClass::checkPHPaymentExpiredAll();
                AdminClass::addCronLog('#'.$i.' Micro PHGH Payment Finish');
                $i++;
                AdminClass::addCronLog('#'.$i.' Micro PHGH Match Start');
                MicroPHGHClass::matchPHGH(50,1);
                MicroPHGHClass::matchPHGH();
                AdminClass::addCronLog('#'.$i.' Micro PHGH Match Finish');
                $i++;
                AdminClass::addCronLog('#'.$i.' Micro PHGH Payment Start');
                MicroPHGHClass::checkPHPaymentStatusAll();
                MicroPHGHClass::checkGHPaymentStatusAll();
                MicroPHGHClass::checkPHPaymentExpiredAll();
                AdminClass::addCronLog('#'.$i.' Micro PHGH Payment Finish');

                $i++;
                AdminClass::addCronLog('#'.$i.' Check GH Skip Ignore Start');
                AdminClass::checkGHSkipIgnore();
                AdminClass::addCronLog('#'.$i.' Check GH Skip Ignore Finish');

                if (AdminClass::fixHierarchy('fix_hierarchy_bank'))
                {
                    $i++;
                    AdminClass::setHierarchy('fix_hierarchy_bank', '0');
                    AdminClass::addCronLog('#' . $i . ' Fix Hierarchy Bank Start');
                    UserClass::reassignReferralHierarchy(2);
                    AdminClass::addCronLog('#' . $i . ' Fix Hierarchy Bank Finish');
                }

                if (AdminClass::fixHierarchy('fix_hierarchy'))
                {
                    $i++;
                    AdminClass::setHierarchy('fix_hierarchy', '0');
                    AdminClass::addCronLog('#' . $i . ' Fix Hierarchy Start');
                    UserClass::reassignPlacementHierarchy(2);
                    AdminClass::addCronLog('#' . $i . ' Fix Hierarchy Finish');
                }

                $i++;
                AdminClass::addCronLog('#'.$i.' Fix Empty Upline Start');
                AdminClass::fixEmptyUpline();
                AdminClass::addCronLog('#'.$i.' Fix Empty Upline Finish');
                
                AdminClass::addCronLog('#'.$i.' Ticket Cron Start');
                Tickets::cronJob();
                AdminClass::addCronLog('#'.$i.' Ticket Cron Finish');
            }

            if ($sys_status == 2)
            {
                $i++;
                AdminClass::addCronLog('#'.$i.' Upgrade Timeout Start');
                PAGBClass::checkUpgradeTimeout();
                AdminClass::addCronLog('#'.$i.' Upgrade Timeout Finish');

                $i++;
                AdminClass::addCronLog('#'.$i.' PAGB Fix Start');
                PAGBFixClass::getPAGBFix();
                AdminClass::addCronLog('#'.$i.' PAGB Fix Finish');

                AdminClass::setUpdate();
            }

            if ($sys_status == 3)
            {
                $i++;
                AdminClass::addCronLog('#' . $i . ' Process Pair Start');
                PairClass::processPair();
                AdminClass::addCronLog('#' . $i . ' Process Pair Finish');
            }

        })->everyFiveMinutes()->name('bitregion')->sendOutputTo('/var/www/html/storage/framework/logs')->withoutOverlapping();
    }
}
