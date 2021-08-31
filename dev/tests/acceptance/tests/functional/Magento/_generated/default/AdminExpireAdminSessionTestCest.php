<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-14111: Admin Session Expire")
 * @Description("Admin Session Expire<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminExpireAdminSessionTest.xml<br>")
 * @TestCaseId("MC-14111")
 * @group Backend
 * @group mtf_migrated
 */
class AdminExpireAdminSessionTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("4. Restore default configuration settings.");
		$setDefaultSessionLifetime = $I->magentoCLI("config:set admin/security/session_lifetime 7200", 60); // stepKey: setDefaultSessionLifetime
		$I->comment($setDefaultSessionLifetime);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Backend"})
	 * @Stories({"Admin Session Expire"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminExpireAdminSessionTest(AcceptanceTester $I)
	{
		$I->comment("1. Apply configuration settings.");
		$changeCookieLifetime = $I->magentoCLI("config:set admin/security/session_lifetime 60", 60); // stepKey: changeCookieLifetime
		$I->comment($changeCookieLifetime);
		$I->comment("2. Wait for session to expire.");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->wait(60); // stepKey: waitForSessionLifetime
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("3. Perform asserts.");
		$I->seeElement(".adminhtml-auth-login"); // stepKey: assertAdminLoginPageIsAvailable
	}
}
