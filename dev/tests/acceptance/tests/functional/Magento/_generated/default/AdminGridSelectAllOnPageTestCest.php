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
 * @Title("MC-37660: Toggle select page.")
 * @Description("Empty selected before and after search, like it works for filter<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminGridSelectAllOnPageTest.xml<br>")
 * @TestCaseId("MC-37660")
 * @group uI
 */
class AdminGridSelectAllOnPageTestCest
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
		$I->comment("Remove created customers");
		$I->deleteEntity("firstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->deleteEntity("secondCustomer", "hook"); // stepKey: deleteSecondCustomer
		$I->deleteEntity("thirdCustomer", "hook"); // stepKey: deleteThirdCustomer
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
	 * @Stories({"Toggle select page."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminGridSelectAllOnPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCustomerPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerPage
		$I->comment("Exiting Action Group [openCustomerPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Select all from dropdown");
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectAllCustomers] AdminGridSelectAllActionGroup");
		$I->waitForElementVisible("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", 30); // stepKey: waitForElementSelectAllCustomers
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownSelectAllCustomers
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: clickSelectAllCustomersSelectAllCustomers
		$I->comment("Exiting Action Group [selectAllCustomers] AdminGridSelectAllActionGroup");
		$I->comment("Deselect third customer");
		$I->click("//*[contains(text(),'" . $I->retrieveEntityField('thirdCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: selectThirdCustomer
		$I->dontSeeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('thirdCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkThirdCustomerCheckboxIsUnchecked
		$I->comment("Click select all on page checkbox");
		$I->comment("Entering Action Group [selectAllCustomersOnPage] AdminSelectAllCustomers");
		$I->checkOption("#container>div>div.admin__data-grid-wrap>table>thead>tr>th.data-grid-multicheck-cell>div>label"); // stepKey: checkAllCustomersSelectAllCustomersOnPage
		$I->comment("Exiting Action Group [selectAllCustomersOnPage] AdminSelectAllCustomers");
		$I->seeElement("#container>div>div.admin__data-grid-wrap>table>thead>tr>th.data-grid-multicheck-cell>div>input"); // stepKey: waitForElement
		$I->seeCheckboxIsChecked("#container>div>div.admin__data-grid-wrap>table>thead>tr>th.data-grid-multicheck-cell>div>input"); // stepKey: checkAllSelectedCheckBoxIsChecked
		$I->comment("Check all created records selected");
		$I->seeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('firstCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkFirstCustomerIsCheckedAfterSelectPage
		$I->seeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('secondCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkSecondCustomerIsCheckedAfterSelectPage
		$I->seeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('thirdCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkThirdCustomerIsCheckedAfterSelectPage
		$I->comment("Click deselect all on page checkbox");
		$I->comment("Entering Action Group [deselectAllCustomersCheckbox] AdminSelectAllCustomers");
		$I->checkOption("#container>div>div.admin__data-grid-wrap>table>thead>tr>th.data-grid-multicheck-cell>div>label"); // stepKey: checkAllCustomersDeselectAllCustomersCheckbox
		$I->comment("Exiting Action Group [deselectAllCustomersCheckbox] AdminSelectAllCustomers");
		$I->dontSeeCheckboxIsChecked("#container>div>div.admin__data-grid-wrap>table>thead>tr>th.data-grid-multicheck-cell>div>input"); // stepKey: checkAllSelectedCheckBoxUnchecked
		$I->comment("Check all created records unselected");
		$I->dontSeeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('firstCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkFirstCustomerIsUncheckedAfterSelectPage
		$I->dontSeeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('secondCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkSecondCustomerIsUncheckedAfterSelectPage
		$I->dontSeeCheckboxIsChecked("//*[contains(text(),'" . $I->retrieveEntityField('thirdCustomer', 'email', 'test') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: checkThirdCustomerIsUncheckedAfterSelectPage
	}
}
