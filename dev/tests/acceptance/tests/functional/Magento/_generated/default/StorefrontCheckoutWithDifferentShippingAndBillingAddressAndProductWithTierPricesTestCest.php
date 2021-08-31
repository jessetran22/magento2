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
 * @Title("MC-14713: Verify checkout with different shipping and billing address and product with tier prices")
 * @Description("Checkout as a customer with different shipping and billing address and  product with tier prices<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckoutWithDifferentShippingAndBillingAddressAndProductWithTierPricesTest.xml<br>")
 * @TestCaseId("MC-14713")
 * @group mtf_migrated
 */
class StorefrontCheckoutWithDifferentShippingAndBillingAddressAndProductWithTierPricesTestCest
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
		$enableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 1", 60); // stepKey: enableBankTransferPayment
		$I->comment($enableBankTransferPayment);
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$simpleProductFields['price'] = "50.00";
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], $simpleProductFields); // stepKey: simpleProduct
		$I->comment("Entering Action Group [filterAndSelectTheProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterFilterAndSelectTheProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct', 'sku', 'hook') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheProduct
		$I->comment("Exiting Action Group [filterAndSelectTheProduct] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [setTierPrice] ProductSetAdvancedTierFixedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonSetTierPrice
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonSetTierPriceWaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonSetTierPrice
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonSetTierPriceWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentSetTierPrice
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentSetTierPriceWaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2SetTierPrice
		$I->selectOption("[name='product[tier_price][0][website_id]']", ""); // stepKey: selectProductWebsiteValueSetTierPrice
		$I->selectOption("[name='product[tier_price][0][cust_group]']", ""); // stepKey: selectProductCustomGroupValueSetTierPrice
		$I->fillField("[name='product[tier_price][0][price_qty]']", "3"); // stepKey: fillProductTierPriceQtyInputSetTierPrice
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Fixed"); // stepKey: selectProductTierPriceValueTypeSetTierPrice
		$I->fillField("[name='product[tier_price][0][price]']", "24.00"); // stepKey: selectProductTierPricePriceInputSetTierPrice
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonSetTierPrice
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonSetTierPriceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveSetTierPrice
		$I->click("#save-button"); // stepKey: clickSaveProduct1SetTierPrice
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1SetTierPriceWaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1SetTierPrice
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationSetTierPrice
		$I->comment("Exiting Action Group [setTierPrice] ProductSetAdvancedTierFixedPricingActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableGuestCheckout = $I->magentoCLI("config:set payment/banktransfer/active 0", 60); // stepKey: enableGuestCheckout
		$I->comment($enableGuestCheckout);
		$I->comment("Sign out Customer from storefront");
		$I->comment("Entering Action Group [openHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenHomePage
		$I->comment("Exiting Action Group [openHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [customerLogout] StorefrontSignOutActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonCustomerLogout
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCustomerLogout
		$I->see("You are signed out"); // stepKey: signOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontSignOutActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("UKCustomer") . "david@email.com"); // stepKey: fillEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("UKCustomer") . "david@email.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
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
	public function StorefrontCheckoutWithDifferentShippingAndBillingAddressAndProductWithTierPricesTest(AcceptanceTester $I)
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
		$I->fillField("input.input-text.qty", "3"); // stepKey: fillProduct1QuantityAddProductToTheCart
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
		$I->comment("Adding the comment to replace waitForPageToLoad action for preserving Backward Compatibility");
		$I->comment("Fill the guest form");
		$I->comment("Entering Action Group [fillGuestForm] FillGuestCheckoutShippingAddressWithCountryActionGroup");
		$I->fillField("#customer-email", msq("UKCustomer") . "david@email.com"); // stepKey: setCustomerEmailFillGuestForm
		$I->fillField("input[name=firstname]", "David"); // stepKey: SetCustomerFirstNameFillGuestForm
		$I->fillField("input[name=lastname]", "Mill"); // stepKey: SetCustomerLastNameFillGuestForm
		$I->fillField("input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: SetCustomerStreetAddressFillGuestForm
		$I->fillField("input[name=city]", "London"); // stepKey: SetCustomerCityFillGuestForm
		$I->selectOption("select[name=country_id]", "GB"); // stepKey: selectCustomerCountryFillGuestForm
		$I->fillField("input[name=postcode]", "12345"); // stepKey: SetCustomerZipCodeFillGuestForm
		$I->fillField("input[name=telephone]", "0123456789-02134567"); // stepKey: SetCustomerPhoneNumberFillGuestForm
		$I->comment("Exiting Action Group [fillGuestForm] FillGuestCheckoutShippingAddressWithCountryActionGroup");
		$I->comment("Entering Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickOnNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickOnNextButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("#banktransfer", 30); // stepKey: waitForPlaceOrderButton
		$I->checkOption("#banktransfer"); // stepKey: selectBankTransfer
		$I->waitForElementVisible("#billing-address-same-as-shipping-banktransfer", 30); // stepKey: waitForElementToBeVisible
		$I->uncheckOption("#billing-address-same-as-shipping-banktransfer"); // stepKey: uncheckSameBillingAndShippingAddress
		$I->waitForElementVisible("//div[contains(@class,'payment-method _active')]//button[contains(@class,'action action-edit-address')]", 30); // stepKey: waitForEditButtonToBeVisible
		$I->waitForPageLoad(30); // stepKey: waitForEditButtonToBeVisibleWaitForPageLoad
		$I->conditionalClick("//div[contains(@class,'payment-method _active')]//button[contains(@class,'action action-edit-address')]", "//div[contains(@class,'payment-method _active')]//button[contains(@class,'action action-edit-address')]", true); // stepKey: clickEditButton
		$I->waitForPageLoad(30); // stepKey: clickEditButtonWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->comment("Fill Billing Address");
		$I->comment("Entering Action Group [fillBillingAddress] StorefrontFillBillingAddressActionGroup");
		$I->fillField(".payment-method._active .billing-address-form input[name='firstname']", "Jane"); // stepKey: enterFirstNameFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='lastname']", "Miller"); // stepKey: enterLastNameFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='street[0]']", "1 London Bridge Street"); // stepKey: enterStreetFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='city']", "London"); // stepKey: enterCityFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='postcode']", "SE12 9GF"); // stepKey: enterPostcodeFillBillingAddress
		$I->selectOption(".payment-method._active .billing-address-form select[name*='country_id']", "GB"); // stepKey: enterCountryFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='telephone']", "44 20 7123 1234"); // stepKey: enterTelephoneFillBillingAddress
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillBillingAddress
		$I->comment("Exiting Action Group [fillBillingAddress] StorefrontFillBillingAddressActionGroup");
		$I->click(".payment-method._active .payment-method-billing-address .action.action-update"); // stepKey: clickOnUpdateButton
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateButtonWaitForPageLoad
		$I->comment("Place order and Assert success message");
		$I->comment("Entering Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickOnPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Assert Empty Mini Cart");
		$I->seeElement("//div[@class='minicart-wrapper']//span[@class='counter qty empty']/../.."); // stepKey: assertEmptyCart
		$orderId = $I->grabTextFrom("//div[contains(@class, 'checkout-success')]//p/span"); // stepKey: orderId
		$I->comment("Register customer after checkout");
		$I->comment("Entering Action Group [registerCustomer] StorefrontRegisterCustomerAfterCheckoutActionGroup");
		$I->click("[data-bind*=\"i18n: 'Create an Account'\"]"); // stepKey: clickOnCreateAnAccountButtonRegisterCustomer
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAnAccountButtonRegisterCustomerWaitForPageLoad
		$I->fillField("#password", "UKCustomer.password"); // stepKey: fillPasswordRegisterCustomer
		$I->fillField("#password-confirmation", "UKCustomer.password"); // stepKey: reconfirmPasswordRegisterCustomer
		$I->click("button.action.submit.primary"); // stepKey: clickOnCreateAnAccountRegisterCustomer
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAnAccountRegisterCustomerWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage1RegisterCustomer
		$I->comment("Exiting Action Group [registerCustomer] StorefrontRegisterCustomerAfterCheckoutActionGroup");
		$I->comment("Assert Billing Address in Storefront");
		$I->see("1 London Bridge Street", "//div[contains(@class,'box box-billing-address')]//div/address"); // stepKey: seeStreetNameInBillingAddress
		$I->see("London", "//div[contains(@class,'box box-billing-address')]//div/address"); // stepKey: seeCityInBillingAddress
		$I->see("United Kingdom", "//div[contains(@class,'box box-billing-address')]//div/address"); // stepKey: seeCountryInBillingAddress
		$I->see("T: 44 20 7123 1234", "//div[contains(@class,'box box-billing-address')]//div/address"); // stepKey: seeTelephoneInBillingAddress
		$I->comment("Assert Shipping Address in Storefront");
		$I->see("172, Westminster Bridge Rd", "//div[contains(@class,'box box-shipping-address')]//div/address"); // stepKey: seeStreetNameInShippingAddress
		$I->see("London", "//div[contains(@class,'box box-shipping-address')]//div/address"); // stepKey: seeCityInShippingAddress
		$I->see("United Kingdom", "//div[contains(@class,'box box-shipping-address')]//div/address"); // stepKey: seeCountryInShippingAddress
		$I->see("T: 0123456789-02134567", "//div[contains(@class,'box box-shipping-address')]//div/address"); // stepKey: seeTelephoneInShippingAddress
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
		$I->see("$87.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeGrandTotal
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
	}
}
