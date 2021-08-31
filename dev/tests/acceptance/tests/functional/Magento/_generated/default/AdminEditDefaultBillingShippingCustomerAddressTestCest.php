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
 * @Title("MAGETWO-94815: Edit default billing/shipping customer address")
 * @Description("Edit default billing/shipping customer address on customer addresses tab<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminEditDefaultBillingShippingCustomerAddressTest.xml<br>")
 * @TestCaseId("MAGETWO-94815")
 * @group customer
 */
class AdminEditDefaultBillingShippingCustomerAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: customer
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
	 * @Stories({"Edit default billing/shipping customer address"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEditDefaultBillingShippingCustomerAddressTest(AcceptanceTester $I)
	{
		$I->comment("-
        Step1. Login to admin and go to Customers > All Customers.
        Step2. On *Customers* page choose customer from preconditions and open it to edit
        Step3. Open *Addresses* tab on edit customer page and press *Add New Address* button
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
		$I->fillField("input[name=email]", msq("Simple_US_Customer_Multiple_Addresses") . "John.Doe@example.com"); // stepKey: filterEmailOpenEditCustomerPage
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
		$I->seeElement("//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seeDefaultBillingAddressSectionBeforeChangingDefaultAddress
		$I->see("368 Broadway St.", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: assertDefaultBillingAddressIsSetBeforeChangingDefaultAddress
		$I->seeElement("//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: seeDefaultShippingAddressSectionBeforeChangingDefaultAddress
		$I->see("368 Broadway St.", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: assertDefaultShippingAddressIsSetBeforeChangingDefaultAddress
		$I->click("//span[text()='Add New Address']"); // stepKey: clickAddNewAddressButton
		$I->waitForPageLoad(30); // stepKey: waitForAddUpdateCustomerAddressForm
		$I->comment("Step4. Fill all the fields with test data and press *Save* button");
		$I->click("div[data-index=default_billing] .admin__actions-switch-label"); // stepKey: enableDefaultBillingAddress
		$I->click("div[data-index=default_shipping] .admin__actions-switch-label"); // stepKey: enableDefaultShippingAddress
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'firstname')]", "John"); // stepKey: fillFirstName
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'lastname')]", "Doe"); // stepKey: fillLastName
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'company')]", "Magento"); // stepKey: fillCompany
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'street')]", "7700 West Parmer Lane"); // stepKey: fillStreet
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'city')]", "Austin"); // stepKey: fillCity
		$I->click("//div[@class='admin__field-control']//select[contains(@name, 'country_id')]"); // stepKey: clickCountryToOpenListOfCountries
		$I->click("//div[@class='admin__field-control']//select[contains(@name, 'country_id')]//option[@value='US']"); // stepKey: fillCountry
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'postcode')]", "78729"); // stepKey: fillPostcode
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'telephone')]", "512-345-6789"); // stepKey: fillTelephone
		$I->click("//div[@class='admin__field-control']//select[@name='region_id']"); // stepKey: clickRegionToOpenListOfRegions
		$I->click("//div[@class='admin__field-control']//select[@name='region_id']//option[@data-title='Texas']"); // stepKey: fillRegion
		$I->click("//button[@title='Save']"); // stepKey: clickSaveCustomerAddressOnAddUpdateAddressForm
		$I->waitForPageLoad(30); // stepKey: waitForNewAddressIsCreated
		$I->see("7700 West Parmer Lane", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: assertDefaultBillingAddressIsChanged
		$I->see("7700 West Parmer Lane", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: assertDefaultShippingAddressIsChanged
		$I->click("//button[@data-index='edit_billing_address']"); // stepKey: clickEditDefaultBillingAddress
		$I->waitForPageLoad(30); // stepKey: waitForCustomerAddressAddUpdateFormLoad
		$I->assertElementContainsAttribute("//div[@class='admin__field-control']//input[@name='default_billing']", "value", "1"); // stepKey: assertDefaultBillingIsEnabledCustomerAddressAddUpdateForm
		$I->assertElementContainsAttribute("//div[@class='admin__field-control']//input[@name='default_shipping']", "value", "1"); // stepKey: assertDefaultShippingIsEnabledOnCustomerAddressAddUpdateForm
	}
}
