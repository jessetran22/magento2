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
 * @Title("MC-38920: Filter by date login as customer logs")
 * @Description("Filter by date should be from/to<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerLoggingFilterTest.xml<br>")
 * @group login_as_customer
 * @TestCaseId("MC-38920")
 */
class AdminLoginAsCustomerLoggingFilterTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->createEntity("createFirstCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createFirstCustomer
		$I->comment("Entering Action Group [loginAsDefaultUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultUser
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultUser
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultUser
		$I->comment("Exiting Action Group [loginAsDefaultUser] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [clearFilterAfter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilterAfter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterAfterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilterAfter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutAsDefaultAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsDefaultAdmin
		$I->comment("Exiting Action Group [logoutAsDefaultAdmin] AdminLogoutActionGroup");
		$I->deleteEntity("createFirstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"Filter by date login as customer logs"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerLoggingFilterTest(AcceptanceTester $I)
	{
		$I->comment("Login into First Customer account");
		$I->comment("Entering Action Group [loginAsFirstCustomerByDefaultAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createFirstCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsFirstCustomerByDefaultAdmin
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomerByDefaultAdminWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsFirstCustomerByDefaultAdmin
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsFirstCustomerByDefaultAdmin
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsFirstCustomerByDefaultAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsFirstCustomerByDefaultAdmin
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsFirstCustomerByDefaultAdmin
		$I->comment("Exiting Action Group [loginAsFirstCustomerByDefaultAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Entering Action Group [signOutFirstCustomerDefaultAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutFirstCustomerDefaultAdmin
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutFirstCustomerDefaultAdmin
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutFirstCustomerDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutFirstCustomerDefaultAdmin
		$I->see("You are signed out"); // stepKey: signOutSignOutFirstCustomerDefaultAdmin
		$I->closeTab(); // stepKey: closeTabSignOutFirstCustomerDefaultAdmin
		$I->comment("Exiting Action Group [signOutFirstCustomerDefaultAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->comment("Navigate to Login as Customer Log page");
		$I->comment("Entering Action Group [gotoLoginAsCustomerLog] AdminOpenLoginAsCustomerLogActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: gotoLoginAsCustomerLogPageGotoLoginAsCustomerLog
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGotoLoginAsCustomerLog
		$I->see("Login as Customer Log"); // stepKey: titleIsVisibleGotoLoginAsCustomerLog
		$I->comment("Exiting Action Group [gotoLoginAsCustomerLog] AdminOpenLoginAsCustomerLogActionGroup");
		$I->comment("Setup date filters");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [filterByToday] AdminLoginAsCustomerLogFilterDatePickerTodayActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersFilterByToday
		$I->click("[name='time[from]'] + button"); // stepKey: clickFromDateFilterByToday
		$I->waitForPageLoad(15); // stepKey: clickFromDateFilterByTodayWaitForPageLoad
		$I->click(".ui-datepicker-today"); // stepKey: clickToTodayFilterByToday
		$I->click("[name='time[to]'] + button"); // stepKey: clickToDateFilterByToday
		$I->waitForPageLoad(15); // stepKey: clickToDateFilterByTodayWaitForPageLoad
		$I->click(".ui-datepicker-today"); // stepKey: clickTodayDateAgainFilterByToday
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterByToday
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterByTodayWaitForPageLoad
		$I->comment("Exiting Action Group [filterByToday] AdminLoginAsCustomerLogFilterDatePickerTodayActionGroup");
		$I->comment("Perform assertions");
		$I->comment("Entering Action Group [verifyDefaultAdminFirstCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: checkUrlVerifyDefaultAdminFirstCustomerLogRecord
		$I->see("1", "//table[@data-role='grid']/tbody/tr[1]/td[4]"); // stepKey: seeCorrectAdminIdVerifyDefaultAdminFirstCustomerLogRecord
		$I->see($I->retrieveEntityField('createFirstCustomer', 'id', 'test'), "//table[@data-role='grid']/tbody/tr[1]/td[2]"); // stepKey: seeCorrectCustomerIdVerifyDefaultAdminFirstCustomerLogRecord
		$I->comment("Exiting Action Group [verifyDefaultAdminFirstCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
	}
}
