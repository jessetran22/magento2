<?php
namespace Magento\AcceptanceTest\_MagentoDeveloperModeOnlyTestSuite\Backend;

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
 * @Title("MC-20374: Check locale dropdown and developer configuration page are available in developer mode")
 * @Description("Check locale dropdown and developer configuration page are available in developer mode<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminCheckLocaleAndDeveloperConfigInDeveloperModeTest.xml<br>")
 * @group backend
 * @group developer_mode_only
 * @group mtf_migrated
 * @TestCaseId("MC-20374")
 */
class AdminCheckLocaleAndDeveloperConfigInDeveloperModeTestCest
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
	}

	/**
	 * @Features({"Backend"})
	 * @Stories({"Menu Navigation"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckLocaleAndDeveloperConfigInDeveloperModeTest(AcceptanceTester $I)
	{
		$I->comment("Go to the general configuration and make sure the locale dropdown is available and enabled");
		$I->comment("Entering Action Group [openStoreConfigPage] AdminOpenStoreConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: openAdminStoreConfigPageOpenStoreConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStoreConfigPage
		$I->comment("Exiting Action Group [openStoreConfigPage] AdminOpenStoreConfigPageActionGroup");
		$I->scrollTo("#general_locale-head", 0, -80); // stepKey: scrollToLocaleSection
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSection
		$I->seeElement("#general_locale_code:enabled"); // stepKey: seeEnabledLocaleDropdown
		$I->comment("Go to the developer configuration and make sure the page is available");
		$I->comment("Entering Action Group [goToDeveloperConfigPage] AdminOpenStoreConfigDeveloperPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/dev/"); // stepKey: openAdminStoreConfigDeveloperPageGoToDeveloperConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToDeveloperConfigPage
		$I->comment("Exiting Action Group [goToDeveloperConfigPage] AdminOpenStoreConfigDeveloperPageActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/dev/"); // stepKey: seeDeveloperConfigUrl
		$I->seeElement("//div[@id='system_config_tabs']//div[@role='tablist']//li[contains(@class, 'nav-item')][contains(.,'Developer')]"); // stepKey: assertDeveloperNavItemPresent
	}
}
