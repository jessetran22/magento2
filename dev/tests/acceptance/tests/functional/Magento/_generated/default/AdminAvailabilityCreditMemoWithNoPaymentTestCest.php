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
 * @Title("MAGETWO-94470: Checking availability of 'Credit memo' button for order with no payment required")
 * @Description("*Credit Memo* button should be displayed<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminAvailabilityCreditMemoWithNoPaymentTest.xml<br>")
 * @TestCaseId("MAGETWO-94470")
 * @group sales
 */
class AdminAvailabilityCreditMemoWithNoPaymentTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Enable *Free Shipping*");
		$I->createEntity("freeShippingMethodsSettingConfig", "hook", "FreeShippingMethodsSettingConfig", [], []); // stepKey: freeShippingMethodsSettingConfig
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
		$I->comment("Disable *Free Shipping*");
		$I->createEntity("defaultShippingMethodsConfig", "hook", "DefaultShippingMethodsConfig", [], []); // stepKey: defaultShippingMethodsConfig
		$I->createEntity("disableFreeShippingConfig", "hook", "DisableFreeShippingConfig", [], []); // stepKey: disableFreeShippingConfig
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("Simple_US_Customer") . "John.Doe@example.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [logOut] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOut
		$I->comment("Exiting Action Group [logOut] AdminLogoutActionGroup");
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
	 * @Stories({"MAGETWO-91547: Unable to create Credit memo for order with no payment required"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAvailabilityCreditMemoWithNoPaymentTest(AcceptanceTester $I)
	{
		$I->comment("Proceed to Admin panel > SALES > Orders. Created order should be in Processing status");
		$I->comment("Entering Action Group [navigateToNewOrderPage] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderPageWaitForPageLoad
		$I->click("#order-customer-selector .actions button.primary"); // stepKey: clickCreateCustomerNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateCustomerNavigateToNewOrderPageWaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderPage
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderPage
		$I->comment("Exiting Action Group [navigateToNewOrderPage] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->comment("Check if order can be submitted without the required fields including email address");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfOrderFormPage
		$I->comment("Entering Action Group [addFirstProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddFirstProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddFirstProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddFirstProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddFirstProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddFirstProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddFirstProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddFirstProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddFirstProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddFirstProductToOrder
		$I->comment("Exiting Action Group [addFirstProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Click *Custom Price* link, enter 0 and click *Update Items and Quantities* button");
		$I->click("//*[@class='custom-price-block']/input"); // stepKey: clickCustomPriceCheckbox
		$I->waitForElementVisible("//*[@class='custom-price-block']/following-sibling::input", 30); // stepKey: waitForPriceFieldAppears
		$I->fillField("//*[@class='custom-price-block']/following-sibling::input", "0"); // stepKey: fillCustomPriceField
		$I->click("//span[contains(text(),'Update Items and Quantities')]"); // stepKey: clickUpdateItemsAndQuantitiesButton
		$I->comment("Fill customer group and customer email");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillCustomerEmail] AdminFillAccountInformationOnCreateOrderPageActionGroup");
		$I->selectOption("#group_id", "General"); // stepKey: selectCustomerGroupFillCustomerEmail
		$I->fillField("#email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillCustomerEmailFillCustomerEmail
		$I->comment("Exiting Action Group [fillCustomerEmail] AdminFillAccountInformationOnCreateOrderPageActionGroup");
		$I->comment("Fill customer address information");
		$I->comment("Entering Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->fillField("#order-billing_address_firstname", "John"); // stepKey: fillFirstNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillFirstNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_lastname", "Doe"); // stepKey: fillLastNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillLastNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_street0", "7700 West Parmer Lane"); // stepKey: fillStreetLine1FillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStreetLine1FillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_city", "Austin"); // stepKey: fillCityFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCityFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_country_id", "US"); // stepKey: fillCountryFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCountryFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_region_id", "Texas"); // stepKey: fillStateFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStateFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_postcode", "78729"); // stepKey: fillPostalCodeFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPostalCodeFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_telephone", "512-345-6789"); // stepKey: fillPhoneFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPhoneFillCustomerAddressWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->comment("Select Free shipping");
		$I->comment("Entering Action Group [selectFreeShippingOption] OrderSelectFreeShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: waitForJavascriptToFinishSelectFreeShippingOption
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsSelectFreeShippingOptionWaitForPageLoad
		$I->waitForElementVisible("#s_method_freeshipping_freeshipping", 30); // stepKey: waitForShippingOptionsSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsSelectFreeShippingOptionWaitForPageLoad
		$I->selectOption("#s_method_freeshipping_freeshipping", "freeshipping_freeshipping"); // stepKey: checkFreeShippingSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: checkFreeShippingSelectFreeShippingOptionWaitForPageLoad
		$I->comment("Exiting Action Group [selectFreeShippingOption] OrderSelectFreeShippingActionGroup");
		$I->comment("Entering Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderClickSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderClickSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadClickSubmitOrder
		$I->comment("Exiting Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Click *Invoice* button");
		$I->comment("Entering Action Group [startCreateInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartCreateInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartCreateInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartCreateInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartCreateInvoice
		$I->comment("Exiting Action Group [startCreateInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Entering Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessSubmitInvoice
		$grabOrderIdSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceSubmitInvoice
		$I->comment("Exiting Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->comment("Verify that *Credit Memo* button is displayed");
		$I->seeElement("#order_creditmemo"); // stepKey: seeCreditMemo
		$I->click("#order_creditmemo"); // stepKey: clickCreditMemoItem
		$I->waitForPageLoad(30); // stepKey: waitForCreditMemoPageLoaded
		$I->see("New Memo", ".page-header h1.page-title"); // stepKey: seeNewMemoPageTitle
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_creditmemo/new/order_id/"); // stepKey: seeNewMemoUrlOnPage
	}
}
