<?php
namespace Magento\AcceptanceTest\_MagentoProductionModeOnlyTestSuite\Backend;

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
 * @Title("MC-14106: Check locale dropdown and developer configuration page are not available in production mode")
 * @Description("Check locale dropdown and developer configuration page are not available in production mode<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminCheckLocaleAndDeveloperConfigInProductionModeTest.xml<br>")
 * @TestCaseId("MC-14106")
 * @group backend
 * @group production_mode_only
 * @group mtf_migrated
 */
class AdminCheckLocaleAndDeveloperConfigInProductionModeTestCest
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
	public function AdminCheckLocaleAndDeveloperConfigInProductionModeTest(AcceptanceTester $I)
	{
		$I->comment("Go to the general configuration and make sure the locale dropdown is disabled");
		$I->comment("Entering Action Group [openStoreConfigPage] AdminOpenStoreConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: openAdminStoreConfigPageOpenStoreConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStoreConfigPage
		$I->comment("Exiting Action Group [openStoreConfigPage] AdminOpenStoreConfigPageActionGroup");
		$I->scrollTo("#general_locale-head", 0, -80); // stepKey: scrollToLocaleSection
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSection
		$I->assertElementContainsAttribute("#general_locale_code", "disabled", ""); // stepKey: seeDisabledLocaleDropdown
		$I->comment("Go to the developer configuration and make sure the redirect to the configuration page takes place");
		$I->comment("Entering Action Group [goToDeveloperConfigPage] AdminOpenStoreConfigDeveloperPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/dev/"); // stepKey: openAdminStoreConfigDeveloperPageGoToDeveloperConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToDeveloperConfigPage
		$I->comment("Exiting Action Group [goToDeveloperConfigPage] AdminOpenStoreConfigDeveloperPageActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/index/"); // stepKey: seeConfigurationIndexUrl
		$I->comment("Entering Action Group [expandAdvancedTab] AdminExpandConfigTabActionGroup");
		$I->scrollTo("//div[@id='system_config_tabs']//div[@data-role='title'][contains(.,'Advanced')]", 0, -80); // stepKey: scrollToTabExpandAdvancedTab
		$I->conditionalClick("//div[@id='system_config_tabs']//div[@data-role='title'][contains(.,'Advanced')]", "//div[@id='system_config_tabs']//div[@data-role='title'][@aria-expanded='true'][contains(.,'Advanced')]", false); // stepKey: expandTabExpandAdvancedTab
		$I->waitForElement("//div[@id='system_config_tabs']//div[@data-role='title'][@aria-expanded='true'][contains(.,'Advanced')]", 30); // stepKey: waitOpenedTabExpandAdvancedTab
		$I->comment("Exiting Action Group [expandAdvancedTab] AdminExpandConfigTabActionGroup");
		$I->dontSeeElement("//div[@id='system_config_tabs']//div[@role='tablist']//li[contains(@class, 'nav-item')][contains(.,'Developer')]"); // stepKey: assertDeveloperNavItemAbsent
	}
}
