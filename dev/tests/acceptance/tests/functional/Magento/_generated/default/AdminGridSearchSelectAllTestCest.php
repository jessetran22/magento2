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
 * @Title("MC-37659: Selection should be removed during search.")
 * @Description("Empty selected before and after search, like it works for filter<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminGridSearchSelectAllTest.xml<br>")
 * @TestCaseId("MC-37659")
 * @group uI
 */
class AdminGridSearchSelectAllTestCest
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
		$I->comment("Create three customers");
		$I->createEntity("firstCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: firstCustomer
		$I->createEntity("secondCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: secondCustomer
		$I->createEntity("thirdCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: thirdCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Remove two created customers, third already deleted");
		$I->deleteEntity("firstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->deleteEntity("secondCustomer", "hook"); // stepKey: deleteSecondCustomer
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
	 * @Stories({"Selection should be removed during search."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminGridSearchSelectAllTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCustomerPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerPage
		$I->comment("Exiting Action Group [openCustomerPage] AdminOpenCustomersGridActionGroup");
		$I->comment("search Admin Data Grid By Keyword");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('secondCustomer', 'email', 'test')); // stepKey: fillKeywordSearchFieldWithSecondCustomerEmail
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Select all from dropdown");
		$I->comment("Entering Action Group [selectAllCustomers] AdminGridSelectAllActionGroup");
		$I->waitForElementVisible("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", 30); // stepKey: waitForElementSelectAllCustomers
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownSelectAllCustomers
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: clickSelectAllCustomersSelectAllCustomers
		$I->comment("Exiting Action Group [selectAllCustomers] AdminGridSelectAllActionGroup");
		$I->comment("Clear searching By Keyword");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAfterSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAfterSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterSearchRemoved
		$I->comment("Check if selection has bee removed");
		$I->dontSeeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('secondCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkSecondCustomerCheckboxIsUnchecked
		$I->comment("Check delete action");
		$I->click("//*[contains(text(),'" . $I->retrieveEntityField('thirdCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: selectThirdCustomer
		$I->seeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('thirdCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkThirdCustomerIsChecked
		$I->comment("Use delete action for selected");
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: clickActions
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: clickDelete
		$I->waitForAjaxLoad(30); // stepKey: waitForLoadConfirmation
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDelete
		$I->waitForPageLoad(60); // stepKey: confirmDeleteWaitForPageLoad
		$I->comment("Check if only one record record has been deleted");
		$I->see("A total of 1 record(s) were deleted", "#messages div.message-success"); // stepKey: seeSuccess
	}
}
