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
 * @Title("MC-14707: Verify product quantity changes in backend after customer checkout")
 * @Description("Checkout as UK customer with bank transfer payment method and verify product quantity reduced after order processed<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontProductQuantityChangesInBackendAfterCustomerCheckoutTest.xml<br>")
 * @TestCaseId("MC-14707")
 * @group mtf_migrated
 */
class StorefrontProductQuantityChangesInBackendAfterCustomerCheckoutTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$enableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 1", 60); // stepKey: enableBankTransferPayment
		$I->comment($enableBankTransferPayment);
		$enableCatalogInventoryStock = $I->magentoCLI("config:set cataloginventory/options/can_subtract 1", 60); // stepKey: enableCatalogInventoryStock
		$I->comment($enableCatalogInventoryStock);
		$simpleProductFields['price'] = "10.00";
		$I->createEntity("simpleProduct", "hook", "defaultSimpleProduct", [], $simpleProductFields); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableGuestCheckout = $I->magentoCLI("config:set payment/banktransfer/active 0", 60); // stepKey: enableGuestCheckout
		$I->comment($enableGuestCheckout);
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductQuantityChangesInBackendAfterCustomerCheckoutTest(AcceptanceTester $I)
	{
		$I->comment("Open Product page in StoreFront and assert product and price range");
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add product to the cart");
		$I->comment("Entering Action Group [addProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddProductToTheCart
		$I->fillField("input.input-text.qty", "100"); // stepKey: fillProduct1QuantityAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddProductToTheCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddProductToTheCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToTheCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddProductToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Open View and edit");
		$I->comment("Entering Action Group [clickMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartClickMiniCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartClickMiniCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartClickMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleClickMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleClickMiniCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartClickMiniCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartClickMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickMiniCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlClickMiniCart
		$I->comment("Exiting Action Group [clickMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Fill the Estimate Shipping and Tax section");
		$I->comment("Entering Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openShippingDetailsFillEstimateShippingAndTaxFields
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='country_id']", "US"); // stepKey: selectCountryFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectCountryFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='region_id']", "Texas"); // stepKey: selectStateFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectStateFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->fillField("input[name='postcode']", "78729"); // stepKey: selectPostCodeFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectPostCodeFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearFillEstimateShippingAndTaxFields
		$I->comment("Exiting Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->comment("Entering Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Fill Customer Sign In Information");
		$I->comment("Entering Action Group [fillGuestForm] FillGuestCheckoutShippingAddressFormActionGroup");
		$I->fillField("#customer-email", msq("UKCustomer") . "david@email.com"); // stepKey: setCustomerEmailFillGuestForm
		$I->fillField("input[name=firstname]", "David"); // stepKey: SetCustomerFirstNameFillGuestForm
		$I->fillField("input[name=lastname]", "Mill"); // stepKey: SetCustomerLastNameFillGuestForm
		$I->fillField("input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: SetCustomerStreetAddressFillGuestForm
		$I->fillField("input[name=city]", "London"); // stepKey: SetCustomerCityFillGuestForm
		$I->fillField("input[name=postcode]", "12345"); // stepKey: SetCustomerZipCodeFillGuestForm
		$I->fillField("input[name=telephone]", "0123456789-02134567"); // stepKey: SetCustomerPhoneNumberFillGuestForm
		$I->comment("Exiting Action Group [fillGuestForm] FillGuestCheckoutShippingAddressFormActionGroup");
		$I->comment("Entering Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickOnNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickOnNextButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("#banktransfer", 30); // stepKey: waitForPlaceOrderButton
		$I->click("#banktransfer"); // stepKey: selectBankTransfer
		$I->comment("Place order and Assert success message");
		$I->comment("Entering Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickOnPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Assert empty Mini Cart");
		$I->seeElement("//div[@class='minicart-wrapper']//span[@class='counter qty empty']/../.."); // stepKey: assertEmptyCart
		$orderId = $I->grabTextFrom("//div[contains(@class, 'checkout-success')]//p/span"); // stepKey: orderId
		$I->comment("Open Order Index Page");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Filter Order using orderId and assert order");
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$orderId"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->click("//td/div[contains(.,'$orderId')]/../..//a[@class='action-menu-item']"); // stepKey: clickOnViewLink
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoad
		$I->comment("Assert Grand Total");
		$I->see("$1,500.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeGrandTotal
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatus
		$I->comment("Ship the order and assert the status");
		$I->comment("Entering Action Group [shipTheOrder] AdminShipThePendingOrderActionGroup");
		$I->waitForElementVisible("#order_ship", 30); // stepKey: waitForShipTabShipTheOrder
		$I->waitForPageLoad(30); // stepKey: waitForShipTabShipTheOrderWaitForPageLoad
		$I->click("#order_ship"); // stepKey: clickShipButtonShipTheOrder
		$I->waitForPageLoad(30); // stepKey: clickShipButtonShipTheOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageToLoadShipTheOrder
		$I->scrollTo("button.action-default.save.submit-button"); // stepKey: scrollToSubmitShipmentButtonShipTheOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitShipmentButtonShipTheOrderWaitForPageLoad
		$I->click("button.action-default.save.submit-button"); // stepKey: clickOnSubmitShipmentButtonShipTheOrder
		$I->waitForPageLoad(60); // stepKey: clickOnSubmitShipmentButtonShipTheOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToProcessShippingPageToLoadShipTheOrder
		$I->see("Processing", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusShipTheOrder
		$I->see("The shipment has been created.", "div.message-success"); // stepKey: seeShipmentCreateSuccessShipTheOrder
		$I->comment("Exiting Action Group [shipTheOrder] AdminShipThePendingOrderActionGroup");
		$I->comment("Assert order buttons");
		$I->comment("Entering Action Group [assertOrderButtons] AdminAssertOrderAvailableButtonsActionGroup");
		$I->seeElement("#back"); // stepKey: seeBackButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeBackButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order-view-cancel-button"); // stepKey: seeCancelButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeCancelButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#send_notification"); // stepKey: seeSendEmailButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeSendEmailButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order-view-hold-button"); // stepKey: seeHoldButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeHoldButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_invoice"); // stepKey: seeInvoiceButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeInvoiceButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_reorder"); // stepKey: seeReorderButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeReorderButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_edit"); // stepKey: seeEditButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeEditButtonAssertOrderButtonsWaitForPageLoad
		$I->comment("Exiting Action Group [assertOrderButtons] AdminAssertOrderAvailableButtonsActionGroup");
		$I->comment("Assert Product Quantity in backend reduced after order processed");
		$I->comment("Entering Action Group [filterAndSelectTheProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterAndSelectTheProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheProduct
		$I->comment("Exiting Action Group [filterAndSelectTheProduct] FilterAndSelectProductActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=name] input", 30); // stepKey: waitForProductDetailsToLoad
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: seeProductName
		$I->seeInField(".admin__field[data-index=qty] input", "0"); // stepKey: seeProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: seeProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusWaitForPageLoad
		$I->comment("Assert Product is Out of Stock in frontend");
		$I->comment("Entering Action Group [assertProductInStorefront] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageAssertProductInStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefront
		$I->seeInTitle($I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: assertProductNameTitleAssertProductInStorefront
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameAssertProductInStorefront
		$I->see($I->retrieveEntityField('simpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefront
		$I->comment("Exiting Action Group [assertProductInStorefront] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->see("Out Of Stock", ".stock[title=Availability]>span"); // stepKey: seeProductDisplayedAsOutOfStock
	}
}
