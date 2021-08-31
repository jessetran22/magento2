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
 * @Title("MC-40646: Checking fields filled from default billing address customer")
 * @Description("Checking fields filled from default billing address customer on create new order page<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCheckingFieldsFilledFromDefaultBillingAddressCustomerInNewOrderTest.xml<br>")
 * @TestCaseId("MC-40646")
 * @group sales
 * @group customer
 */
class AdminCheckingFieldsFilledFromDefaultBillingAddressCustomerInNewOrderTestCest
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
		$I->createEntity("createCustomer", "hook", "Customer_With_Vat_Number", [], []); // stepKey: createCustomer
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
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Sales"})
	 * @Stories({"Create order in Admin"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckingFieldsFilledFromDefaultBillingAddressCustomerInNewOrderTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderWithExistingCustomer
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderWithExistingCustomer
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderWithExistingCustomer
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderWithExistingCustomer
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderWithExistingCustomer
		$I->comment("Exiting Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [assertFieldsFilled] AssertAdminBillingAddressFieldsOnOrderCreateFormActionGroup");
		$getNamePrefixAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_prefix"); // stepKey: getNamePrefixAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getNamePrefixAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("", $getNamePrefixAssertFieldsFilled); // stepKey: assertNamePrefixAssertFieldsFilled
		$getFirstNameAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_firstname"); // stepKey: getFirstNameAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getFirstNameAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("John", $getFirstNameAssertFieldsFilled); // stepKey: assertFirstNameAssertFieldsFilled
		$getMiddleNameAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_middlename"); // stepKey: getMiddleNameAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getMiddleNameAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("", $getMiddleNameAssertFieldsFilled); // stepKey: assertMiddleNameAssertFieldsFilled
		$getLastNameAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_lastname"); // stepKey: getLastNameAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getLastNameAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("Doe", $getLastNameAssertFieldsFilled); // stepKey: assertLastNameAssertFieldsFilled
		$getNameSuffixAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_suffix"); // stepKey: getNameSuffixAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getNameSuffixAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("", $getNameSuffixAssertFieldsFilled); // stepKey: assertNameSuffixAssertFieldsFilled
		$getCompanyAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_company"); // stepKey: getCompanyAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getCompanyAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("Magento", $getCompanyAssertFieldsFilled); // stepKey: assertCompanyAssertFieldsFilled
		$getStreetLine1AssertFieldsFilled = $I->grabValueFrom("#order-billing_address_street0"); // stepKey: getStreetLine1AssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getStreetLine1AssertFieldsFilledWaitForPageLoad
		$I->assertEquals("7700 West Parmer Lane", $getStreetLine1AssertFieldsFilled); // stepKey: assertStreetLine1AssertFieldsFilled
		$getStreetLine2AssertFieldsFilled = $I->grabValueFrom("#order-billing_address_street1"); // stepKey: getStreetLine2AssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getStreetLine2AssertFieldsFilledWaitForPageLoad
		$I->assertEquals("113", $getStreetLine2AssertFieldsFilled); // stepKey: assertStreetLine2AssertFieldsFilled
		$getCountrySelectedOptionAssertFieldsFilled = $I->grabTextFrom("#order-billing_address_country_id option:checked"); // stepKey: getCountrySelectedOptionAssertFieldsFilled
		$I->assertEquals("United States", $getCountrySelectedOptionAssertFieldsFilled); // stepKey: assertCountrySelectedOptionAssertFieldsFilled
		$getStateSelectedOptionAssertFieldsFilled = $I->grabTextFrom("#order-billing_address_region_id option:checked"); // stepKey: getStateSelectedOptionAssertFieldsFilled
		$I->assertEquals("California", $getStateSelectedOptionAssertFieldsFilled); // stepKey: assertStateSelectedOptionAssertFieldsFilled
		$getProvinceAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_region"); // stepKey: getProvinceAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getProvinceAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("", $getProvinceAssertFieldsFilled); // stepKey: assertProvinceAssertFieldsFilled
		$getCityAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_city"); // stepKey: getCityAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getCityAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("Los Angeles", $getCityAssertFieldsFilled); // stepKey: assertCityAssertFieldsFilled
		$getPostCodeAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_postcode"); // stepKey: getPostCodeAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getPostCodeAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("90001", $getPostCodeAssertFieldsFilled); // stepKey: assertPostCodeAssertFieldsFilled
		$getPhoneAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_telephone"); // stepKey: getPhoneAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getPhoneAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("512-345-6789", $getPhoneAssertFieldsFilled); // stepKey: assertPhoneAssertFieldsFilled
		$getFaxAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_fax"); // stepKey: getFaxAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getFaxAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("", $getFaxAssertFieldsFilled); // stepKey: assertFaxAssertFieldsFilled
		$getVatNumberAssertFieldsFilled = $I->grabValueFrom("#order-billing_address_vat_id"); // stepKey: getVatNumberAssertFieldsFilled
		$I->waitForPageLoad(30); // stepKey: getVatNumberAssertFieldsFilledWaitForPageLoad
		$I->assertEquals("U1234567891", $getVatNumberAssertFieldsFilled); // stepKey: assertVatNumberAssertFieldsFilled
		$I->comment("Exiting Action Group [assertFieldsFilled] AssertAdminBillingAddressFieldsOnOrderCreateFormActionGroup");
	}
}
