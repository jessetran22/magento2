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
 * @Title("MC-25924: Checks that Instant Purchase functionality works fine")
 * @Description("Checks that customer with different billing and shipping addresses work with Instant Purchase functionality fine<h3>Test files</h3>app/code/Magento/InstantPurchase/Test/Mftf/Test/StorefrontInstantPurchaseFunctionalityTest.xml<br>")
 * @TestCaseId("MC-25924")
 * @group instant_purchase
 * @group vault
 * @group paypal
 */
class StorefrontInstantPurchaseFunctionalityTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add", 60, "example.com static.magento.com"); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Configure Paypal Payflow Pro payment method");
		$I->createEntity("configurePaypalPayflowProPayment", "hook", "PaypalPayflowProConfig", [], []); // stepKey: configurePaypalPayflowProPayment
		$I->comment("Enable Paypal Payflow Pro with Vault");
		$I->createEntity("enablePaypalPayflowProPaymentWithVault", "hook", "EnablePaypalPayflowProWithVault", [], []); // stepKey: enablePaypalPayflowProPaymentWithVault
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomer
		$I->comment("Create all product variations");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", [], []); // stepKey: createVirtualProduct
		$I->comment("Entering Action Group [createConfigurableProduct] AdminCreateApiConfigurableProductActionGroup");
		$I->comment("Create the configurable product based on the data in the /data folder");
		$createConfigProductCreateConfigurableProductFields['name'] = "API Configurable Product" . msq("ApiConfigurableProductWithOutCategory");
		$I->createEntity("createConfigProductCreateConfigurableProduct", "hook", "ApiConfigurableProductWithOutCategory", [], $createConfigProductCreateConfigurableProductFields); // stepKey: createConfigProductCreateConfigurableProduct
		$I->comment("Create attribute with 2 options to be used in children products");
		$I->createEntity("createConfigProductAttributeCreateConfigurableProduct", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttributeCreateConfigurableProduct
		$I->createEntity("createConfigProductAttributeOption1CreateConfigurableProduct", "hook", "productAttributeOption1", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: createConfigProductAttributeOption1CreateConfigurableProduct
		$I->createEntity("createConfigProductAttributeOption2CreateConfigurableProduct", "hook", "productAttributeOption2", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: createConfigProductAttributeOption2CreateConfigurableProduct
		$I->createEntity("addAttributeToAttributeSetCreateConfigurableProduct", "hook", "AddToDefaultSet", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: addAttributeToAttributeSetCreateConfigurableProduct
		$I->getEntity("getConfigAttributeOption1CreateConfigurableProduct", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct"], null, 1); // stepKey: getConfigAttributeOption1CreateConfigurableProduct
		$I->getEntity("getConfigAttributeOption2CreateConfigurableProduct", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct"], null, 2); // stepKey: getConfigAttributeOption2CreateConfigurableProduct
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1CreateConfigurableProduct", "hook", "ApiSimpleOne", ["createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption1CreateConfigurableProduct"], []); // stepKey: createConfigChildProduct1CreateConfigurableProduct
		$I->createEntity("createConfigChildProduct2CreateConfigurableProduct", "hook", "ApiSimpleTwo", ["createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption2CreateConfigurableProduct"], []); // stepKey: createConfigChildProduct2CreateConfigurableProduct
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOptionCreateConfigurableProduct", "hook", "ConfigurableProductTwoOptions", ["createConfigProductCreateConfigurableProduct", "createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption1CreateConfigurableProduct", "getConfigAttributeOption2CreateConfigurableProduct"], []); // stepKey: createConfigProductOptionCreateConfigurableProduct
		$I->createEntity("createConfigProductAddChild1CreateConfigurableProduct", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct", "createConfigChildProduct1CreateConfigurableProduct"], []); // stepKey: createConfigProductAddChild1CreateConfigurableProduct
		$I->createEntity("createConfigProductAddChild2CreateConfigurableProduct", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct", "createConfigChildProduct2CreateConfigurableProduct"], []); // stepKey: createConfigProductAddChild2CreateConfigurableProduct
		$I->comment("Exiting Action Group [createConfigurableProduct] AdminCreateApiConfigurableProductActionGroup");
		$I->comment("Create Bundle Product");
		$I->createEntity("createBundleProduct", "hook", "ApiFixedBundleProduct", [], []); // stepKey: createBundleProduct
		$I->createEntity("createBundleOption", "hook", "DropDownBundleOption", ["createBundleProduct"], []); // stepKey: createBundleOption
		$I->createEntity("createBundleLink", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption", "createSimpleProduct"], []); // stepKey: createBundleLink
		$I->comment("Create Downloadable Product");
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], []); // stepKey: createDownloadableProduct
		$I->createEntity("addDownloadableLink", "hook", "downloadableLink1", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink
		$I->comment("Create Grouped Product");
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct", [], []); // stepKey: createGroupedProduct
		$I->createEntity("createLinkForGroupedProduct", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createSimpleProduct"], []); // stepKey: createLinkForGroupedProduct
		$I->comment("Log in as a customer");
		$I->comment("Entering Action Group [customerLoginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'hook')); // stepKey: fillEmailCustomerLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'hook')); // stepKey: fillPasswordCustomerLoginToStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginToStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLoginToStorefront
		$I->comment("Exiting Action Group [customerLoginToStorefront] LoginToStorefrontActionGroup");
		$I->comment("Customer placed order from storefront with payment method");
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [setShippingMethodFlatRate] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethodSetShippingMethodFlatRate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSetShippingMethodFlatRate
		$I->comment("Exiting Action Group [setShippingMethodFlatRate] StorefrontSetShippingMethodActionGroup");
		$I->comment("Entering Action Group [goToCheckoutPaymentStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutPaymentStep
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutPaymentStepWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutPaymentStep
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutPaymentStepWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutPaymentStep
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutPaymentStepWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutPaymentStep
		$I->comment("Exiting Action Group [goToCheckoutPaymentStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Fill Paypal card data");
		$I->click("#co-payment-form .payment-method #payflowpro"); // stepKey: selectPaypalPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForPaypalFormLoad
		$I->scrollTo("#co-payment-form .payment-method #payflowpro"); // stepKey: scrollToCreditCardSection
		$I->comment("Entering Action Group [fillCardDataPaypal] StorefrontPaypalFillCardDataActionGroup");
		$I->fillField("#payflowpro_cc_number", "4000000000000002"); // stepKey: setCartNumberFillCardDataPaypal
		$I->fillField("#payflowpro_cc_cid", "113"); // stepKey: setVerificationNumberFillCardDataPaypal
		$I->selectOption("#payflowpro_cc_type_exp_div .select-month", "12"); // stepKey: setMonthFillCardDataPaypal
		$I->selectOption("#payflowpro_cc_type_exp_div .select-year", "30"); // stepKey: setYearFillCardDataPaypal
		$I->comment("Exiting Action Group [fillCardDataPaypal] StorefrontPaypalFillCardDataActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFillCardData
		$I->checkOption("input[name='vault[is_enabled]']"); // stepKey: checkSaveForLaterUse
		$I->comment("Entering Action Group [clickOnPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberClickOnPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] CheckoutPlaceOrderActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Set configs to default");
		$I->createEntity("defaultPaypalPayflowProConfig", "hook", "DefaultPaypalPayflowProConfig", [], []); // stepKey: defaultPaypalPayflowProConfig
		$I->createEntity("rollbackPaypalPayflowProConfig", "hook", "RollbackPaypalPayflowPro", [], []); // stepKey: rollbackPaypalPayflowProConfig
		$I->comment("Remove created products/attributes");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createVirtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
		$I->comment("Remove Downloadable Product");
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->deleteEntity("createDownloadableProduct", "hook"); // stepKey: deleteDownloadableProduct
		$I->comment("Remove Configurable Product");
		$I->deleteEntity("createConfigProductCreateConfigurableProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttributeCreateConfigurableProduct", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createConfigChildProduct1CreateConfigurableProduct", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2CreateConfigurableProduct", "hook"); // stepKey: deleteConfigChildProduct2
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
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
	 * @Features({"InstantPurchase"})
	 * @Stories({"Using Instant Purchase"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontInstantPurchaseFunctionalityTest(AcceptanceTester $I)
	{
		$I->comment("1. Browse all product page and verify that the \"Instant Purchase\" button appears");
		$I->comment("Virtual product");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openVirtualProductPage
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForButtonOnVirtualProductPage
		$I->comment("Downloadable Product");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openDownloadableProductPage
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForButtonOnDownloadableProductPage
		$I->comment("Bundle Product");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openBundleProductPage
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButton
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonWaitForPageLoad
		$I->comment("Entering Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeAndAddToCart
		$I->comment("Exiting Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForButtonOnBundleProductPage
		$I->comment("Grouped product");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openGroupedProductPage
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForButtonOnGroupedProductPage
		$I->comment("Configurable Product");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openConfigurableProductPage
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForButtonOnConfigurableProductPage
		$I->comment("2. Click on \"Instant Purchase\" and assert information");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openSimpleProductPage
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForInstantPurchaseButton
		$I->comment("Entering Action Group [assertInstantPurchasePopupData] AssertStorefrontInstantPurchaseConfirmationDataActionGroup");
		$I->click("button.instant-purchase"); // stepKey: clickInstantPurchaseButtonAssertInstantPurchasePopupData
		$I->waitForElementVisible("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]", 30); // stepKey: waitForButtonAppearsAssertInstantPurchasePopupData
		$I->waitForPageLoad(30); // stepKey: waitForButtonAppearsAssertInstantPurchasePopupDataWaitForPageLoad
		$I->seeElement("//aside[contains(@class, 'modal-popup')]//strong[contains(text(),'Shipping Address:')]/following-sibling::p[contains(text(),'368 Broadway St.')][1]"); // stepKey: assertShippingAddressAssertInstantPurchasePopupData
		$I->seeElement("//aside[contains(@class, 'modal-popup')]//strong[contains(text(),'Billing Address:')]/following-sibling::p[contains(text(),'368 Broadway St.')]"); // stepKey: assertBillingAddressAssertInstantPurchasePopupData
		$I->seeElement("//aside[contains(@class, 'modal-popup')]//strong[contains(text(),'Payment Method:')]/following-sibling::p[contains(text(),'0002')]"); // stepKey: assertCardEndingAssertInstantPurchasePopupData
		$I->comment("Exiting Action Group [assertInstantPurchasePopupData] AssertStorefrontInstantPurchaseConfirmationDataActionGroup");
		$I->comment("3. Confirm Instant Purchase");
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: placeOrderAgain
		$I->waitForPageLoad(30); // stepKey: placeOrderAgainWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessage
		$I->see("Your order number is:", "div.message-success.success.message"); // stepKey: seePlaceOrderSuccessMessage
		$I->comment("4. Customer changes his default address");
		$I->amOnPage("/customer/address/"); // stepKey: goToAddressPage
		$I->click("//tbody//tr[1]//a[@class='action edit']"); // stepKey: clickOnEditAdditionalAddressButton
		$I->waitForPageLoad(30); // stepKey: clickOnEditAdditionalAddressButtonWaitForPageLoad
		$I->checkOption("//form[@class='form-address-edit']//input[@name='default_billing']"); // stepKey: checkUseAsDefaultBillingAddressCheckbox
		$I->comment("Entering Action Group [saveAddress] AdminSaveCustomerAddressActionGroup");
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddressSaveAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressSaveAddressWaitForPageLoad
		$I->see("You saved the address.", "div.message-success.success.message"); // stepKey: seeSuccessMessageSaveAddress
		$I->comment("Exiting Action Group [saveAddress] AdminSaveCustomerAddressActionGroup");
		$I->comment("5.1 Customer places a new order from the storefront with new payment credentials");
		$I->comment("Entering Action Group [addProductToCartAgain] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCartAgain
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCartAgain
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCartAgain
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartAgainWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCartAgain
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCartAgain
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCartAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCartAgain
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCartAgain
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCartAgain
		$I->comment("Exiting Action Group [addProductToCartAgain] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicartAgain] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicartAgain
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicartAgain
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicartAgain
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartAgainWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicartAgain
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartAgainWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicartAgain] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [setShippingMethodFlatRateAgain] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethodSetShippingMethodFlatRateAgain
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSetShippingMethodFlatRateAgain
		$I->comment("Exiting Action Group [setShippingMethodFlatRateAgain] StorefrontSetShippingMethodActionGroup");
		$I->click("//div/following-sibling::div/button[contains(@class, 'action-select-shipping-item')]"); // stepKey: changeShippingAddress
		$I->comment("Entering Action Group [goToCheckoutPaymentStepAgain] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutPaymentStepAgain
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutPaymentStepAgainWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutPaymentStepAgain
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutPaymentStepAgainWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutPaymentStepAgain
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutPaymentStepAgainWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutPaymentStepAgain
		$I->comment("Exiting Action Group [goToCheckoutPaymentStepAgain] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Fill Paypal card data");
		$I->click("#co-payment-form .payment-method #payflowpro"); // stepKey: selectPaypalPaymentMethodAgain
		$I->waitForPageLoad(30); // stepKey: waitForPaypalFormLoadAgain
		$I->scrollTo("#co-payment-form .payment-method #payflowpro"); // stepKey: scrollToCreditCardSectionAgain
		$I->comment("Entering Action Group [fillCardDataAgain] StorefrontPaypalFillCardDataActionGroup");
		$I->fillField("#payflowpro_cc_number", "4111111111111111"); // stepKey: setCartNumberFillCardDataAgain
		$I->fillField("#payflowpro_cc_cid", "123"); // stepKey: setVerificationNumberFillCardDataAgain
		$I->selectOption("#payflowpro_cc_type_exp_div .select-month", "01"); // stepKey: setMonthFillCardDataAgain
		$I->selectOption("#payflowpro_cc_type_exp_div .select-year", "30"); // stepKey: setYearFillCardDataAgain
		$I->comment("Exiting Action Group [fillCardDataAgain] StorefrontPaypalFillCardDataActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFillCardDataAgain
		$I->comment("5.2 Customer save this payment method");
		$I->checkOption("input[name='vault[is_enabled]']"); // stepKey: checkSaveForLaterUseAgain
		$I->comment("Entering Action Group [clickOnPlaceOrderAgain] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderAgain
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderAgainWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrderAgain
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderAgainWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberClickOnPlaceOrderAgain
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouClickOnPlaceOrderAgain
		$I->comment("Exiting Action Group [clickOnPlaceOrderAgain] CheckoutPlaceOrderActionGroup");
		$I->comment("6. Customer opens simple product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openSimpleProductPageAgain
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForInstantPurchaseButtonAgain
		$I->comment("7. Click on \"Instant Purchase\" and verify that information are different from previous");
		$I->comment("Entering Action Group [assertInstantPurchasePopupDataAgain] AssertStorefrontInstantPurchaseConfirmationDataActionGroup");
		$I->click("button.instant-purchase"); // stepKey: clickInstantPurchaseButtonAssertInstantPurchasePopupDataAgain
		$I->waitForElementVisible("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]", 30); // stepKey: waitForButtonAppearsAssertInstantPurchasePopupDataAgain
		$I->waitForPageLoad(30); // stepKey: waitForButtonAppearsAssertInstantPurchasePopupDataAgainWaitForPageLoad
		$I->seeElement("//aside[contains(@class, 'modal-popup')]//strong[contains(text(),'Shipping Address:')]/following-sibling::p[contains(text(),'368 Broadway St.')][1]"); // stepKey: assertShippingAddressAssertInstantPurchasePopupDataAgain
		$I->seeElement("//aside[contains(@class, 'modal-popup')]//strong[contains(text(),'Billing Address:')]/following-sibling::p[contains(text(),'172, Westminster Bridge Rd')]"); // stepKey: assertBillingAddressAssertInstantPurchasePopupDataAgain
		$I->seeElement("//aside[contains(@class, 'modal-popup')]//strong[contains(text(),'Payment Method:')]/following-sibling::p[contains(text(),'1111')]"); // stepKey: assertCardEndingAssertInstantPurchasePopupDataAgain
		$I->comment("Exiting Action Group [assertInstantPurchasePopupDataAgain] AssertStorefrontInstantPurchaseConfirmationDataActionGroup");
		$I->comment("8. Confirm Instant Purchase");
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: placeOrderFinalTime
		$I->waitForPageLoad(30); // stepKey: placeOrderFinalTimeWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAgain
		$I->see("Your order number is:", "div.message-success.success.message"); // stepKey: seePlaceOrderSuccessMessageAgain
	}
}
