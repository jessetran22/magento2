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
 * @Title("[NO TESTCASEID]: Admin Create Order")
 * @Description("Verify, admin able to create order with customer without email.<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderWithCustomerWithoutEmailTest.xml<br>")
 * @group Sales
 */
class AdminCreateOrderWithCustomerWithoutEmailTestCest
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
		$I->comment("Disable required 'email' field on create order page.");
		$disableRequiredFieldEmailForAdminOrderCreation = $I->magentoCLI("config:set customer/create_account/email_required_create_order 0", 60); // stepKey: disableRequiredFieldEmailForAdminOrderCreation
		$I->comment($disableRequiredFieldEmailForAdminOrderCreation);
		$I->comment("Create test data.");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("simpleProduct", "hook", "SimpleProduct", ["category"], []); // stepKey: simpleProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Clean up created test data.");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->comment("Enable required 'email' field on create order page.");
		$enableRequiredFieldEmailForAdminOrderCreation = $I->magentoCLI("config:set customer/create_account/email_required_create_order 1", 60); // stepKey: enableRequiredFieldEmailForAdminOrderCreation
		$I->comment($enableRequiredFieldEmailForAdminOrderCreation);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"Admin create order with customer without email."})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderWithCustomerWithoutEmailTest(AcceptanceTester $I)
	{
		$I->comment("Create order.");
		$I->comment("Entering Action Group [navigateToNewOrderPageNewCustomerActionGroup] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderPageNewCustomerActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderPageNewCustomerActionGroup
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderPageNewCustomerActionGroup
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderPageNewCustomerActionGroup
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderPageNewCustomerActionGroupWaitForPageLoad
		$I->click("#order-customer-selector .actions button.primary"); // stepKey: clickCreateCustomerNavigateToNewOrderPageNewCustomerActionGroup
		$I->waitForPageLoad(30); // stepKey: clickCreateCustomerNavigateToNewOrderPageNewCustomerActionGroupWaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageNewCustomerActionGroup
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageNewCustomerActionGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderPageNewCustomerActionGroup
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderPageNewCustomerActionGroup
		$I->comment("Exiting Action Group [navigateToNewOrderPageNewCustomerActionGroup] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1000"); // stepKey: fillProductQtyAddSimpleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Fill customer address without 'email'");
		$I->comment("Entering Action Group [fillCustomerInformation] FillOrderCustomerInformationActionGroup");
		$I->fillField("#order-billing_address_firstname", "John"); // stepKey: fillFirstNameFillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillFirstNameFillCustomerInformationWaitForPageLoad
		$I->fillField("#order-billing_address_lastname", "Doe"); // stepKey: fillLastNameFillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillLastNameFillCustomerInformationWaitForPageLoad
		$I->fillField("#order-billing_address_street0", "7700 West Parmer Lane"); // stepKey: fillStreetLine1FillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillStreetLine1FillCustomerInformationWaitForPageLoad
		$I->fillField("#order-billing_address_city", "Los Angeles"); // stepKey: fillCityFillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillCityFillCustomerInformationWaitForPageLoad
		$I->selectOption("#order-billing_address_country_id", "US"); // stepKey: fillCountryFillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillCountryFillCustomerInformationWaitForPageLoad
		$I->selectOption("#order-billing_address_region_id", "California"); // stepKey: fillStateFillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillStateFillCustomerInformationWaitForPageLoad
		$I->fillField("#order-billing_address_postcode", "90001"); // stepKey: fillPostalCodeFillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillPostalCodeFillCustomerInformationWaitForPageLoad
		$I->fillField("#order-billing_address_telephone", "512-345-6789"); // stepKey: fillPhoneFillCustomerInformation
		$I->waitForPageLoad(30); // stepKey: fillPhoneFillCustomerInformationWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerInformation] FillOrderCustomerInformationActionGroup");
		$I->comment("Entering Action Group [orderSelectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusOrderSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishOrderSelectFlatRateShippingMethod
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: checkFlatRateOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->comment("Exiting Action Group [orderSelectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Verify, 'email' is generated.");
		$I->comment("Entering Action Group [verifyCustomerEmail] VerifyCreatedOrderInformationWithGeneratedEmailActionGroup");
		$I->see("@example.com", ".order-account-information table tr:nth-of-type(2) > td a"); // stepKey: seeGeneratedEmailVerifyCustomerEmail
		$I->comment("Exiting Action Group [verifyCustomerEmail] VerifyCreatedOrderInformationWithGeneratedEmailActionGroup");
		$generatedCustomerEmail = $I->grabTextFrom(".order-account-information table tr:nth-of-type(2) > td a"); // stepKey: generatedCustomerEmail
		$I->comment("Entering Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForAdminCustomerPageLoadDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonDeleteCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersDeleteCustomer
		$I->fillField("input[name=email]", "$generatedCustomerEmail"); // stepKey: filterEmailDeleteCustomer
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
	}
}
