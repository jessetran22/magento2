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
 * @Title("MAGETWO-94952: Admin should be able to set customer default billing address")
 * @Description("Admin should be able to set customer default billing address from customer addresses grid row actions<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminSetCustomerDefaultBillingAddressTest.xml<br>")
 * @TestCaseId("MAGETWO-94952")
 * @group customer
 */
class AdminSetCustomerDefaultBillingAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer_Multiple_Addresses_No_Default_Address", [], []); // stepKey: customer
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
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Set customer default billing address"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSetCustomerDefaultBillingAddressTest(AcceptanceTester $I)
	{
		$I->comment("-
        Step1. Login to admin and go to Customers > All Customers.
        Step2. On *Customers* page choose customer from preconditions and open it to edit
        Step3. On edit customer page open *Addresses* tab and find a grid with the additional addresses
        <!-");
		$I->comment("Entering Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomersGridPage
		$I->comment("Exiting Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [openEditCustomerPage] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenEditCustomerPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenEditCustomerPageWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: openFilterOpenEditCustomerPageWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer_Multiple_Addresses_No_Default_Address") . "John.Doe@example.com"); // stepKey: filterEmailOpenEditCustomerPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerPage
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerPage
		$I->comment("Exiting Action Group [openEditCustomerPage] OpenEditCustomerFromAdminActionGroup");
		$I->click("//a[@id='tab_address']"); // stepKey: openAddressesTab
		$I->waitForPageLoad(30); // stepKey: openAddressesTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddresses
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickOnButtonToRemoveFiltersIfPresent
		$I->waitForPageLoad(30); // stepKey: clickOnButtonToRemoveFiltersIfPresentWaitForPageLoad
		$I->fillField("#fulltext", "368 Broadway St."); // stepKey: fillCustomerAddressStreetInSearchByKeyword
		$I->pressKey("#fulltext", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterKey
		$I->waitForPageLoad(30); // stepKey: waitForCustomerAddressesGridPageLoad
		$I->see("The customer does not have default billing address", "//div[@class='customer-default-billing-address-content']//address//span"); // stepKey: assertThatThereIsNoDefaultBillingAddress
		$I->seeNumberOfElements("//tr[contains(@class,'data-row')]", "1"); // stepKey: seeOnlyOneCustomerAddressesInGrid
		$I->comment("Step4. Click *Select* link in *Actions* column for target additional address");
		$I->click("//tr[contains(@data-repeat-index, '0')]//button[@class='action-select']"); // stepKey: clickSelectElementFromRow
		$I->comment("Step4. Click *Set as default billing*");
		$I->click("//tr[contains(@data-repeat-index, '0')]//a[contains(@data-action,'item-setDefaultBilling')]"); // stepKey: clickOnSetAddressAsDefaultBilling
		$I->waitForPageLoad(30); // stepKey: clickOnSetAddressAsDefaultBillingWaitForPageLoad
		$I->comment("Step5. Press *Ok* button on the pop-up");
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmSetAddressAsDefaultBilling
		$I->waitForPageLoad(60); // stepKey: confirmSetAddressAsDefaultBillingWaitForPageLoad
		$I->seeElement("//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seeDefaultBillingAddressSection
		$I->see("368 Broadway St.", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: assertDefaultBillingAddressIsSet
		$I->click("//button[@data-index='edit_billing_address']"); // stepKey: clickEditDefaultBillingAddress
		$I->waitForPageLoad(30); // stepKey: waitForCustomerAddressAddUpdateFormLoad
		$I->assertElementContainsAttribute("//div[@class='admin__field-control']//input[@name='default_billing']", "value", "1"); // stepKey: assertDefaultBillingCheckboxIsCheckedOnCustomerAddressAddUpdateForm
	}
}
