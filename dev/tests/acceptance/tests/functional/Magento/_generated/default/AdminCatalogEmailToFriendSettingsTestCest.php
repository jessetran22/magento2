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
 * @Title("MC-35895: Admin should be able to manage settings of Email To A Friend Functionality")
 * @Description("Admin should be able to enable Email To A Friend functionality in Magento Admin backend and see additional options<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminCatalogEmailToFriendSettingsTest.xml<br>")
 * @group backend
 * @TestCaseId("MC-35895")
 */
class AdminCatalogEmailToFriendSettingsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$enableSendFriend = $I->magentoCLI("config:set sendfriend/email/enabled 1", 60); // stepKey: enableSendFriend
		$I->comment($enableSendFriend);
		$cacheClean = $I->magentoCLI("cache:clean config", 60); // stepKey: cacheClean
		$I->comment($cacheClean);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$disableSendFriend = $I->magentoCLI("config:set sendfriend/email/enabled 0", 60); // stepKey: disableSendFriend
		$I->comment($disableSendFriend);
		$cacheClean = $I->magentoCLI("cache:clean config", 60); // stepKey: cacheClean
		$I->comment($cacheClean);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Enable Email To A Friend Functionality"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCatalogEmailToFriendSettingsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToSendFriendSettings] AdminNavigateToEmailToFriendSettingsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/sendfriend/"); // stepKey: navigateToPersistencePageNavigateToSendFriendSettings
		$I->conditionalClick(".entry-edit-head-link", ".entry-edit-head-link:not(.open)", true); // stepKey: clickTabNavigateToSendFriendSettings
		$I->comment("Exiting Action Group [navigateToSendFriendSettings] AdminNavigateToEmailToFriendSettingsActionGroup");
		$I->comment("Entering Action Group [assertOptions] AssertAdminEmailToFriendOptionsAvailableActionGroup");
		$I->seeElement("#sendfriend_email_template"); // stepKey: seeEmailTemplateInputAssertOptions
		$I->seeElement("#sendfriend_email_allow_guest"); // stepKey: seeAllowForGuestsInputAssertOptions
		$I->seeElement("#sendfriend_email_max_recipients"); // stepKey: seeMaxRecipientsInputAssertOptions
		$I->seeElement("#sendfriend_email_max_per_hour"); // stepKey: seeMaxPerHourInputAssertOptions
		$I->seeElement("#sendfriend_email_check_by"); // stepKey: seeLimitSendingByAssertOptions
		$I->comment("Exiting Action Group [assertOptions] AssertAdminEmailToFriendOptionsAvailableActionGroup");
	}
}
