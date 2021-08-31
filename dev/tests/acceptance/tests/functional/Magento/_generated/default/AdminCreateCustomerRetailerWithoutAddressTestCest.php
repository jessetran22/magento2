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
 * @Title("MC-5310: Create customer, retailer without address")
 * @Description("Login as admin and create customer retailer without address<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCreateCustomerRetailerWithoutAddressTest.xml<br>")
 * @TestCaseId("MC-5310")
 * @group mtf_migrated
 */
class AdminCreateCustomerRetailerWithoutAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForAdminCustomerPageLoadDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonDeleteCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersDeleteCustomer
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: applyFilterDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomer
		$I->click("//td[@class='data-grid-checkbox-cell']"); // stepKey: clickOnEditButton1DeleteCustomer
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: clickActionsDropdownDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickActionsDropdownDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: clickDeleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//button[@data-role='action']//span[text()='OK']", 30); // stepKey: waitForOkToVisibleDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForOkToVisibleDeleteCustomerWaitForPageLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkConfirmationButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickOkConfirmationButtonDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//*[@class='message message-success success']", 30); // stepKey: waitForSuccessfullyDeletedMessageDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
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
	 * @Stories({"Create customer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCustomerRetailerWithoutAddressTest(AcceptanceTester $I)
	{
		$I->comment("Filter the customer From grid");
		$I->comment("Entering Action Group [navigateToNewCustomerPage] AdminNavigateNewCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/new"); // stepKey: navigateToCustomersNavigateToNewCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadNavigateToNewCustomerPage
		$I->comment("Exiting Action Group [navigateToNewCustomerPage] AdminNavigateNewCustomerActionGroup");
		$I->selectOption("[name='customer[group_id]']", "Retailer"); // stepKey: fillCustomerGroup
		$I->fillField("input[name='customer[firstname]']", "John"); // stepKey: fillFirstName
		$I->fillField("input[name='customer[lastname]']", "Doe"); // stepKey: fillLastName
		$I->fillField("input[name='customer[email]']", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmail
		$I->click("#save"); // stepKey: saveCustomer
		$I->waitForPageLoad(30); // stepKey: saveCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessage
		$I->reloadPage(); // stepKey: reloadPage
		$I->comment("Verify Customer in grid");
		$I->comment("Entering Action Group [filterTheCustomerByEmail1] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterTheCustomerByEmail1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomerByEmail1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterTheCustomerByEmail1WaitForPageLoad
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmailFilterTheCustomerByEmail1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterTheCustomerByEmail1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterTheCustomerByEmail1
		$I->comment("Exiting Action Group [filterTheCustomerByEmail1] AdminFilterCustomerByEmail");
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageToLoad
		$I->see("Retailer", "table[data-role='grid']"); // stepKey: assertGroup
		$I->see("John", "table[data-role='grid']"); // stepKey: assertFirstName
		$I->see("Doe", "table[data-role='grid']"); // stepKey: assertLastName
		$I->see(msq("CustomerEntityOne") . "test@email.com", "table[data-role='grid']"); // stepKey: assertEmail
		$I->comment("Assert Customer Form");
		$I->comment("Entering Action Group [clickOnEditButton1] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickOnEditButton1
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickOnEditButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickOnEditButton1
		$I->comment("Exiting Action Group [clickOnEditButton1] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("//a/span[text()='Account Information']"); // stepKey: clickOnAccountInformation
		$I->waitForPageLoad(30); // stepKey: waitForCustomerInformationPageToLoad
		$I->see("Retailer", "//*[@name='customer[group_id]']/option"); // stepKey: seeCustomerGroup1
		$I->seeInField("input[name='customer[firstname]']", "John"); // stepKey: seeCustomerFirstName
		$I->seeInField("input[name='customer[lastname]']", "Doe"); // stepKey: seeCustomerLastName
		$I->seeInField("input[name='customer[email]']", msq("CustomerEntityOne") . "test@email.com"); // stepKey: seeCustomerEmail
	}
}
