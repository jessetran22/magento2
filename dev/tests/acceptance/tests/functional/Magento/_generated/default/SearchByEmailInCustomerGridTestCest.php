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
 * @Title("MC-17985: Admin customer grid email searching")
 * @Description("Admin customer grid searching by email in keyword<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/SearchByEmailInCustomerGridTest.xml<br>")
 * @TestCaseId("MC-17985")
 * @group customer
 */
class SearchByEmailInCustomerGridTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createFirstCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createFirstCustomer
		$I->createEntity("createSecondCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createSecondCustomer
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->deleteEntity("createSecondCustomer", "hook"); // stepKey: deleteSecondCustomer
		$I->comment("Entering Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomersGridPage
		$I->comment("Exiting Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [clearCustomerGridFilter] AdminResetFilterInCustomerAddressGrid");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersClearCustomerGridFilter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClearCustomerGridFilterWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabClearCustomerGridFilter
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewClearCustomerGridFilter
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewClearCustomerGridFilterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadClearCustomerGridFilter
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedClearCustomerGridFilter
		$I->comment("Exiting Action Group [clearCustomerGridFilter] AdminResetFilterInCustomerAddressGrid");
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
	 * @Features({"Customer"})
	 * @Stories({"Customer grid search"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function SearchByEmailInCustomerGridTest(AcceptanceTester $I)
	{
		$I->comment("Step 1: Go to Customers > All Customers");
		$I->comment("Entering Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomersGridPage
		$I->comment("Exiting Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Step 2: On Customers grid page search customer by keyword");
		$I->comment("Entering Action Group [searchCustomer] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchCustomerWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createSecondCustomer', 'email', 'test')); // stepKey: fillKeywordSearchFieldSearchCustomer
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchCustomer
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [searchCustomer] SearchAdminDataGridByKeywordActionGroup");
		$I->comment("Step 3: Check if customer is placed in a first row and clear grid filter");
		$I->comment("Entering Action Group [checkCustomerInGrid] AdminAssertCustomerInCustomersGrid");
		$I->see($I->retrieveEntityField('createSecondCustomer', 'email', 'test'), "//*[@data-role='sticky-el-root']/parent::div/parent::div/following-sibling::div//tbody//*[@class='data-row'][1]"); // stepKey: seeCustomerInGridCheckCustomerInGrid
		$I->comment("Exiting Action Group [checkCustomerInGrid] AdminAssertCustomerInCustomersGrid");
	}
}
