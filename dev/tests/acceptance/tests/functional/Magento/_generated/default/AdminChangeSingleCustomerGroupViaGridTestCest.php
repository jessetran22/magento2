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
 * @Title("MC-26039: Change a single customer group via grid")
 * @Description("From the selection of All Customers select a single customer to change their group<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminChangeSingleCustomerGroupViaGridTest.xml<br>")
 * @TestCaseId("MC-26039")
 * @group customer
 * @group mtf_migrated
 */
class AdminChangeSingleCustomerGroupViaGridTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCustomerGroup", "hook", "CustomerGroupChange", [], []); // stepKey: createCustomerGroup
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCustomerGroup", "hook"); // stepKey: deleteCustomerGroup
		$I->comment("Entering Action Group [navigateToCustomersPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageNavigateToCustomersPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCustomersPage
		$I->comment("Exiting Action Group [navigateToCustomersPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [clearCustomersGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearCustomersGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearCustomersGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearCustomersGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Stories({"Customer Edit"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminChangeSingleCustomerGroupViaGridTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCustomersPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageNavigateToCustomersPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCustomersPage
		$I->comment("Exiting Action Group [navigateToCustomersPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [filterCustomer] AdminFilterCustomerGridByEmail");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersFilterCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterCustomerWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersFilterCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersFilterCustomerWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailFilterCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersFilterCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [filterCustomer] AdminFilterCustomerGridByEmail");
		$I->comment("Entering Action Group [selectCustomer] AdminSelectCustomerByEmail");
		$I->checkOption("//tr[@class='data-row' and //div[text()='" . $I->retrieveEntityField('createCustomer', 'email', 'test') . "']]//input[@type='checkbox']"); // stepKey: checkCustomerBoxSelectCustomer
		$I->waitForPageLoad(30); // stepKey: checkCustomerBoxSelectCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [selectCustomer] AdminSelectCustomerByEmail");
		$I->comment("Entering Action Group [setCustomerGroup] SetCustomerGroupForSelectedCustomersViaGrid");
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: clickActionsSetCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickActionsSetCustomerGroupWaitForPageLoad
		$I->click("//div[@class='admin__data-grid-outer-wrap']/div[@class='admin__data-grid-header']//span[text()='Assign a Customer Group']"); // stepKey: clickAssignActionSetCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickAssignActionSetCustomerGroupWaitForPageLoad
		$scrollToGroupSetCustomerGroup = $I->executeJS("document.getElementsByClassName('action-menu _active')[0].scrollBy(0, 10000)"); // stepKey: scrollToGroupSetCustomerGroup
		$I->click("//div[@class='admin__data-grid-outer-wrap']/div[@class='admin__data-grid-header']//ul[@class='action-submenu _active']//span[text()='" . $I->retrieveEntityField('createCustomerGroup', 'code', 'test') . "']"); // stepKey: selectGroupSetCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitAfterSelectingGroupSetCustomerGroup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptModalSetCustomerGroup
		$I->waitForPageLoad(60); // stepKey: acceptModalSetCustomerGroupWaitForPageLoad
		$I->comment("Exiting Action Group [setCustomerGroup] SetCustomerGroupForSelectedCustomersViaGrid");
		$I->comment("Entering Action Group [filterCustomerAfterGroupChange] AdminFilterCustomerGridByEmail");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersFilterCustomerAfterGroupChange
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterCustomerAfterGroupChangeWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersFilterCustomerAfterGroupChange
		$I->waitForPageLoad(30); // stepKey: openFiltersFilterCustomerAfterGroupChangeWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailFilterCustomerAfterGroupChange
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersFilterCustomerAfterGroupChange
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterCustomerAfterGroupChangeWaitForPageLoad
		$I->comment("Exiting Action Group [filterCustomerAfterGroupChange] AdminFilterCustomerGridByEmail");
		$I->comment("Entering Action Group [verifyCustomerGroupSet] VerifyCustomerGroupForCustomer");
		$I->click("//tr[@class='data-row' and //div[text()='" . $I->retrieveEntityField('createCustomer', 'email', 'test') . "']]//a[@class='action-menu-item']"); // stepKey: openCustomerPageVerifyCustomerGroupSet
		$I->waitForPageLoad(30); // stepKey: openCustomerPageVerifyCustomerGroupSetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageVerifyCustomerGroupSet
		$I->see($I->retrieveEntityField('createCustomerGroup', 'code', 'test'), "//th[text()='Customer Group:']/../td"); // stepKey: checkCustomerGroupVerifyCustomerGroupSet
		$I->comment("Exiting Action Group [verifyCustomerGroupSet] VerifyCustomerGroupForCustomer");
	}
}
