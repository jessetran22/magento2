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
 * @Title("MC-28285: Verify guest checkout using free shipping and tax variations")
 * @Description("Verify guest checkout using free shipping and tax variations<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontVerifyGuestCheckoutUsingFreeShippingAndTaxesTest.xml<br>")
 * @TestCaseId("MC-28285")
 * @group mtf_migrated
 * @group checkout
 * @group tax
 */
class StorefrontVerifyGuestCheckoutUsingFreeShippingAndTaxesTestCest
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
		$I->createEntity("enableFlatRate", "hook", "FlatRateShippingMethodConfig", [], []); // stepKey: enableFlatRate
		$I->createEntity("freeShippingMethodsSettingConfig", "hook", "FreeShippingMethodsSettingConfig", [], []); // stepKey: freeShippingMethodsSettingConfig
		$I->createEntity("minimumOrderAmount", "hook", "MinimumOrderAmount100", [], []); // stepKey: minimumOrderAmount
		$I->createEntity("createTaxRateUSNY", "hook", "taxRate_US_NY_8_1", [], []); // stepKey: createTaxRateUSNY
		$I->createEntity("createTaxRuleUSNY", "hook", "DefaultTaxRuleWithCustomTaxRate", ["createTaxRateUSNY"], []); // stepKey: createTaxRuleUSNY
		$simpleProductFields['price'] = "10.00";
		$I->createEntity("simpleProduct", "hook", "defaultSimpleProduct", [], $simpleProductFields); // stepKey: simpleProduct
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("configurableProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: configurableProduct
		$I->createEntity("createProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createProductAttribute
		$I->createEntity("createProductAttributeOption", "hook", "productAttributeOption1", ["createProductAttribute"], []); // stepKey: createProductAttributeOption
		$I->createEntity("addToDefaultSet", "hook", "AddToDefaultSet", ["createProductAttribute"], []); // stepKey: addToDefaultSet
		$I->getEntity("getProductAttributeOption", "hook", "ProductAttributeOptionGetter", ["createProductAttribute"], null, 1); // stepKey: getProductAttributeOption
		$configurableChildProductFields['price'] = "10.00";
		$I->createEntity("configurableChildProduct", "hook", "ApiSimpleOne", ["createProductAttribute", "getProductAttributeOption"], $configurableChildProductFields); // stepKey: configurableChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["configurableProduct", "createProductAttribute", "getProductAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("configurableProductAddChild", "hook", "ConfigurableProductAddChild", ["configurableProduct", "configurableChildProduct"], []); // stepKey: configurableProductAddChild
		$firstBundleChildProductFields['price'] = "100.00";
		$I->createEntity("firstBundleChildProduct", "hook", "SimpleProduct2", [], $firstBundleChildProductFields); // stepKey: firstBundleChildProduct
		$secondBundleChildProductFields['price'] = "200.00";
		$I->createEntity("secondBundleChildProduct", "hook", "SimpleProduct2", [], $secondBundleChildProductFields); // stepKey: secondBundleChildProduct
		$I->createEntity("bundleProduct", "hook", "BundleProductPriceViewRange", ["createCategory"], []); // stepKey: bundleProduct
		$bundleOptionFields['required'] = "True";
		$I->createEntity("bundleOption", "hook", "MultipleSelectOption", ["bundleProduct"], $bundleOptionFields); // stepKey: bundleOption
		$I->createEntity("firstLinkOptionToProduct", "hook", "ApiBundleLink", ["bundleProduct", "bundleOption", "firstBundleChildProduct"], []); // stepKey: firstLinkOptionToProduct
		$I->createEntity("secondLinkOptionToProduct", "hook", "ApiBundleLink", ["bundleProduct", "bundleOption", "secondBundleChildProduct"], []); // stepKey: secondLinkOptionToProduct
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("configurableChildProduct", "hook"); // stepKey: deleteConfigurableChildProduct
		$I->deleteEntity("configurableProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->deleteEntity("firstBundleChildProduct", "hook"); // stepKey: deleteFirstBundleChild
		$I->deleteEntity("secondBundleChildProduct", "hook"); // stepKey: deleteSecondBundleChild
		$I->deleteEntity("bundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createTaxRuleUSNY", "hook"); // stepKey: deleteTaxRuleUSNY
		$I->deleteEntity("createTaxRateUSNY", "hook"); // stepKey: deleteTaxRateUSNY
		$I->createEntity("defaultShippingMethodsConfig", "hook", "DefaultShippingMethodsConfig", [], []); // stepKey: defaultShippingMethodsConfig
		$I->createEntity("defaultMinimumOrderAmount", "hook", "DefaultMinimumOrderAmount", [], []); // stepKey: defaultMinimumOrderAmount
		$I->comment("Entering Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdminPanel
		$I->comment("Exiting Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"Checkout"})
	 * @Stories({"Checkout via Guest Checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyGuestCheckoutUsingFreeShippingAndTaxesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Entering Action Group [addSimpleProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddSimpleProductToTheCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityAddSimpleProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddSimpleProductToTheCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddSimpleProductToTheCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddSimpleProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddSimpleProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSimpleProductToTheCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddSimpleProductToTheCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddSimpleProductToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addSimpleProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Entering Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
		$I->amOnPage($I->retrieveEntityField('configurableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontPageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductFrontPageToLoadAddConfigurableProductToCart
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getProductAttributeOption', 'label', 'test')); // stepKey: selectOption1AddConfigurableProductToCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProductQuantityAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: fillProductQuantityAddConfigurableProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddConfigurableProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddConfigurableProductToCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCartWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
		$I->comment("Entering Action Group [openProductPageAndVerifyBundleProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('bundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyBundleProduct
		$I->seeInTitle($I->retrieveEntityField('bundleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyBundleProduct
		$I->see($I->retrieveEntityField('bundleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyBundleProduct
		$I->see($I->retrieveEntityField('bundleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyBundleProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyBundleProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Entering Action Group [addBundleProductToCart] StorefrontAddBundleProductFromProductToCartWithMultiOptionActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAndAddToCartAddBundleProductToCart
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAndAddToCartAddBundleProductToCartWaitForPageLoad
		$I->selectOption("//label//span[contains(text(), '" . $I->retrieveEntityField('bundleOption', 'name', 'test') . "')]/../..//select[@multiple='multiple']", $I->retrieveEntityField('firstBundleChildProduct', 'name', 'test') . " +$100.00"); // stepKey: selectValueAddBundleProductToCart
		$I->click("#product-addtocart-button"); // stepKey: clickAddBundleProductToCartAddBundleProductToCart
		$I->waitForPageLoad(30); // stepKey: clickAddBundleProductToCartAddBundleProductToCartWaitForPageLoad
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 30); // stepKey: waitProductCountAddBundleProductToCart
		$I->see("You added " . $I->retrieveEntityField('bundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeSuccessMessageAddBundleProductToCart
		$I->comment("Exiting Action Group [addBundleProductToCart] StorefrontAddBundleProductFromProductToCartWithMultiOptionActionGroup");
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
		$I->comment("Entering Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openShippingDetailsFillEstimateShippingAndTaxFields
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='country_id']", "US"); // stepKey: selectCountryFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectCountryFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='region_id']", "New York"); // stepKey: selectStateFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectStateFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->fillField("input[name='postcode']", "10001"); // stepKey: selectPostCodeFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectPostCodeFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearFillEstimateShippingAndTaxFields
		$I->comment("Exiting Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->click("#s_method_freeshipping_freeshipping"); // stepKey: selectShippingMethod
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodWaitForPageLoad
		$I->see("$9.72", "[data-th='Tax']>span"); // stepKey: seeTaxAmount
		$I->reloadPage(); // stepKey: reloadThePage
		$I->waitForPageLoad(30); // stepKey: waitForPageToReload
		$I->see("$9.72", "[data-th='Tax']>span"); // stepKey: seeTaxAmountAfterLoadPage
		$I->scrollTo(".action.primary.checkout span"); // stepKey: scrollToProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: scrollToProceedToCheckoutWaitForPageLoad
		$I->comment("Entering Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForPageToLoad action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [fillTheSignInForm] FillGuestCheckoutShippingAddressFormActionGroup");
		$I->fillField("#customer-email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: setCustomerEmailFillTheSignInForm
		$I->fillField("input[name=firstname]", "John"); // stepKey: SetCustomerFirstNameFillTheSignInForm
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: SetCustomerLastNameFillTheSignInForm
		$I->fillField("input[name='street[0]']", "368 Broadway St."); // stepKey: SetCustomerStreetAddressFillTheSignInForm
		$I->fillField("input[name=city]", "New York"); // stepKey: SetCustomerCityFillTheSignInForm
		$I->fillField("input[name=postcode]", "10001"); // stepKey: SetCustomerZipCodeFillTheSignInForm
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: SetCustomerPhoneNumberFillTheSignInForm
		$I->comment("Exiting Action Group [fillTheSignInForm] FillGuestCheckoutShippingAddressFormActionGroup");
		$I->comment("Entering Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickOnNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickOnNextButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Entering Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickOnPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->seeElement("//div[@class='minicart-wrapper']//span[@class='counter qty empty']/../.."); // stepKey: assertEmptyCart
		$orderId = $I->grabTextFrom("//div[contains(@class, 'checkout-success')]//p/span"); // stepKey: orderId
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [openOrderById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrderById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrderById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrderById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrderById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$orderId"); // stepKey: fillOrderIdFilterOpenOrderById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrderById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrderById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrderById
		$I->comment("Exiting Action Group [openOrderById] OpenOrderByIdActionGroup");
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
		$I->see("$129.72", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeGrandTotal
		$I->comment("Entering Action Group [seeOrderPendingStatus] AdminOrderViewCheckStatusActionGroup");
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusSeeOrderPendingStatus
		$I->comment("Exiting Action Group [seeOrderPendingStatus] AdminOrderViewCheckStatusActionGroup");
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
		$I->comment("Entering Action Group [assertCustomerInformation] AssertOrderAddressInformationActionGroup");
		$I->see("368 Broadway St.", ".order-billing-address address"); // stepKey: seeBillingAddressStreetAssertCustomerInformation
		$I->see("New York", ".order-billing-address address"); // stepKey: seeBillingAddressCityAssertCustomerInformation
		$I->see("United States", ".order-billing-address address"); // stepKey: seeBillingCountryAssertCustomerInformation
		$I->see("10001", ".order-billing-address address"); // stepKey: seeBillingAddressPostcodeAssertCustomerInformation
		$I->see("368 Broadway St.", ".order-shipping-address address"); // stepKey: seeShippingAddressStreetAssertCustomerInformation
		$I->see("New York", ".order-shipping-address address"); // stepKey: seeShippingAddressCityAssertCustomerInformation
		$I->see("United States", ".order-shipping-address address"); // stepKey: seeAddressCountryAssertCustomerInformation
		$I->see("10001", ".order-shipping-address address"); // stepKey: seeShippingAddressPostcodeAssertCustomerInformation
		$I->comment("Exiting Action Group [assertCustomerInformation] AssertOrderAddressInformationActionGroup");
	}
}
