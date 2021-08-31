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
 * @Title("MC-25949: Checks negative Instant Purchase functionality scenario")
 * @Description("Checks that Instant Purchase button does not appear in a different situation<h3>Test files</h3>app/code/Magento/InstantPurchase/Test/Mftf/Test/StorefrontInstantPurchaseFunctionalityNegativeScenarioTest.xml<br>")
 * @TestCaseId("MC-25949")
 * @group instant_purchase
 * @group vault
 * @group paypal
 */
class StorefrontInstantPurchaseFunctionalityNegativeScenarioTestCest
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
		$I->comment("Create customers: without address, with address, with saved shipping and billing");
		$I->createEntity("customerWithoutAddress", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: customerWithoutAddress
		$I->createEntity("customerWithAddress", "hook", "Simple_US_Customer_Multiple_Addresses_No_Default_Address", [], []); // stepKey: customerWithAddress
		$I->createEntity("customerWithDefaultAddress", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: customerWithDefaultAddress
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
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Log in as a customer");
		$I->comment("Entering Action Group [customerLoginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('customerWithDefaultAddress', 'email', 'hook')); // stepKey: fillEmailCustomerLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('customerWithDefaultAddress', 'password', 'hook')); // stepKey: fillPasswordCustomerLoginToStorefront
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
		$I->fillField("#payflowpro_cc_number", "4111111111111111"); // stepKey: setCartNumberFillCardDataPaypal
		$I->fillField("#payflowpro_cc_cid", "123"); // stepKey: setVerificationNumberFillCardDataPaypal
		$I->selectOption("#payflowpro_cc_type_exp_div .select-month", "01"); // stepKey: setMonthFillCardDataPaypal
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
		$I->deleteEntity("customerWithoutAddress", "hook"); // stepKey: deleteCustomerWithoutAddress
		$I->deleteEntity("customerWithAddress", "hook"); // stepKey: deleteCustomerWithAddress
		$I->deleteEntity("customerWithDefaultAddress", "hook"); // stepKey: deleteCustomerWithDefaultAddress
		$I->comment("Set configs to default");
		$restoreToDefaultFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: restoreToDefaultFlatRate
		$I->comment($restoreToDefaultFlatRate);
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
		$reindexInvalidatedIndicesAfterTest = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndicesAfterTest
		$I->comment($reindexInvalidatedIndicesAfterTest);
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
	public function StorefrontInstantPurchaseFunctionalityNegativeScenarioTest(AcceptanceTester $I)
	{
		$I->comment("1. Ensure customer is a guest");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->comment("2. Browse all product pages and verify that the \"Instant Purchase\" button does not appear");
		$I->comment("Simple product");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnSimpleProductPage
		$I->comment("Virtual product");
		$I->comment("Entering Action Group [openVirtualProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenVirtualProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenVirtualProductPage
		$I->comment("Exiting Action Group [openVirtualProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnVirtualProductPage
		$I->comment("Downloadable Product");
		$I->comment("Entering Action Group [openDownloadableProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenDownloadableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenDownloadableProductPage
		$I->comment("Exiting Action Group [openDownloadableProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnDownloadableProductPage
		$I->comment("Bundle Product");
		$I->comment("Entering Action Group [openBundleProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenBundleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenBundleProductPage
		$I->comment("Exiting Action Group [openBundleProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButton
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonWaitForPageLoad
		$I->comment("Entering Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeAndAddToCart
		$I->comment("Exiting Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductPageLoad
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnBundleProductPage
		$I->comment("Grouped product");
		$I->comment("Entering Action Group [openGroupedProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenGroupedProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenGroupedProductPage
		$I->comment("Exiting Action Group [openGroupedProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnGroupedProductPage
		$I->comment("Configurable Product");
		$I->comment("Entering Action Group [openConfigurableProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenConfigurableProductPage
		$I->comment("Exiting Action Group [openConfigurableProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnConfigurableProductPage
		$I->comment("3. Log in as a customer without address");
		$I->comment("Entering Action Group [customerWithoutAddressLoginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerWithoutAddressLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerWithoutAddressLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerWithoutAddressLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('customerWithoutAddress', 'email', 'test')); // stepKey: fillEmailCustomerWithoutAddressLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('customerWithoutAddress', 'password', 'test')); // stepKey: fillPasswordCustomerWithoutAddressLoginToStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerWithoutAddressLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerWithoutAddressLoginToStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerWithoutAddressLoginToStorefront
		$I->comment("Exiting Action Group [customerWithoutAddressLoginToStorefront] LoginToStorefrontActionGroup");
		$I->comment("4. Browse simple product page and check that Instant Purchase button does not show up");
		$I->comment("Entering Action Group [openSimpleProductPageWithCustomerWithoutAddress] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPageWithCustomerWithoutAddress
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPageWithCustomerWithoutAddress
		$I->comment("Exiting Action Group [openSimpleProductPageWithCustomerWithoutAddress] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnSimpleProductAsCustomerWithoutAddress
		$I->comment("5. Log in as a customer with address");
		$I->comment("Entering Action Group [logoutCustomerWithoutAddress] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomerWithoutAddress
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomerWithoutAddress
		$I->comment("Exiting Action Group [logoutCustomerWithoutAddress] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [customerWithAddressLoginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerWithAddressLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerWithAddressLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerWithAddressLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('customerWithAddress', 'email', 'test')); // stepKey: fillEmailCustomerWithAddressLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('customerWithAddress', 'password', 'test')); // stepKey: fillPasswordCustomerWithAddressLoginToStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerWithAddressLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerWithAddressLoginToStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerWithAddressLoginToStorefront
		$I->comment("Exiting Action Group [customerWithAddressLoginToStorefront] LoginToStorefrontActionGroup");
		$I->comment("6. Browse simple product page and check that Instant Purchase button does not show up");
		$I->comment("Entering Action Group [openSimpleProductPageWithCustomerWithAddress] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPageWithCustomerWithAddress
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPageWithCustomerWithAddress
		$I->comment("Exiting Action Group [openSimpleProductPageWithCustomerWithAddress] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnSimpleProductPageAsCustomerWithAddress
		$I->comment("7. Log in as a customer with default address");
		$I->comment("Entering Action Group [logoutCustomerWithAddress] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomerWithAddress
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomerWithAddress
		$I->comment("Exiting Action Group [logoutCustomerWithAddress] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [customerWithDefaultAddressLoginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerWithDefaultAddressLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerWithDefaultAddressLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerWithDefaultAddressLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('customerWithDefaultAddress', 'email', 'test')); // stepKey: fillEmailCustomerWithDefaultAddressLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('customerWithDefaultAddress', 'password', 'test')); // stepKey: fillPasswordCustomerWithDefaultAddressLoginToStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerWithDefaultAddressLoginToStorefront
		$I->comment("Exiting Action Group [customerWithDefaultAddressLoginToStorefront] LoginToStorefrontActionGroup");
		$I->comment("8. Browse simple product page and check that Instant Purchase button show up");
		$I->comment("Entering Action Group [openSimpleProductPageWithCustomerWithDefaultAddress] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPageWithCustomerWithDefaultAddress
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPageWithCustomerWithDefaultAddress
		$I->comment("Exiting Action Group [openSimpleProductPageWithCustomerWithDefaultAddress] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForInstantPurchaseButton
		$I->comment("9-10. Configure Braintree Payment Method(without Vault). Configure 3d Secure Verification");
		$disableVault = $I->magentoCLI("config:set payment/payflowpro_cc_vault/active 0", 60); // stepKey: disableVault
		$I->comment($disableVault);
		$I->comment("New session should be started");
		$I->comment("Entering Action Group [logoutCustomerWithDefaultAddressAfter3dSecureEnabled] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomerWithDefaultAddressAfter3dSecureEnabled
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomerWithDefaultAddressAfter3dSecureEnabled
		$I->comment("Exiting Action Group [logoutCustomerWithDefaultAddressAfter3dSecureEnabled] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [customerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled
		$I->fillField("#email", $I->retrieveEntityField('customerWithDefaultAddress', 'email', 'test')); // stepKey: fillEmailCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled
		$I->fillField("#pass", $I->retrieveEntityField('customerWithDefaultAddress', 'password', 'test')); // stepKey: fillPasswordCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabledWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled
		$I->comment("Exiting Action Group [customerWithDefaultAddressLoginToStorefrontAfter3dSecureEnabled] LoginToStorefrontActionGroup");
		$I->comment("11. Browse simple product page and check that Instant Purchase button does not show up");
		$I->comment("Entering Action Group [openSimpleProductPageWith3dSecureEnabled] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPageWith3dSecureEnabled
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPageWith3dSecureEnabled
		$I->comment("Exiting Action Group [openSimpleProductPageWith3dSecureEnabled] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnSimpleProductPageWith3dSecureEnabled
		$I->comment("12. Disable all supported payment methods");
		$I->createEntity("defaultPaypalPayflowProConfig", "test", "DefaultPaypalPayflowProConfig", [], []); // stepKey: defaultPaypalPayflowProConfig
		$I->createEntity("rollbackPaypalPayflowProConfig", "test", "RollbackPaypalPayflowPro", [], []); // stepKey: rollbackPaypalPayflowProConfig
		$I->comment("New session should be started");
		$I->comment("Entering Action Group [logoutCustomerWithDefaultAddressAfterPaymentMethodDisabled] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomerWithDefaultAddressAfterPaymentMethodDisabled
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomerWithDefaultAddressAfterPaymentMethodDisabled
		$I->comment("Exiting Action Group [logoutCustomerWithDefaultAddressAfterPaymentMethodDisabled] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [customerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled
		$I->fillField("#email", $I->retrieveEntityField('customerWithDefaultAddress', 'email', 'test')); // stepKey: fillEmailCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled
		$I->fillField("#pass", $I->retrieveEntityField('customerWithDefaultAddress', 'password', 'test')); // stepKey: fillPasswordCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabledWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled
		$I->comment("Exiting Action Group [customerWithDefaultAddressLoginToStorefrontAfterPaymentMethodDisabled] LoginToStorefrontActionGroup");
		$I->comment("13. Browse simple product page and check that Instant Purchase button does not show up");
		$I->comment("Entering Action Group [openSimpleProductPageWhilePaymentMethodDisabled] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPageWhilePaymentMethodDisabled
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPageWhilePaymentMethodDisabled
		$I->comment("Exiting Action Group [openSimpleProductPageWhilePaymentMethodDisabled] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnSimpleProductWhilePaymentMethodDisabled
		$I->comment("14. Reenable supported payment method");
		$I->createEntity("reenablePaypalPayflowProPayment", "test", "PaypalPayflowProConfig", [], []); // stepKey: reenablePaypalPayflowProPayment
		$I->createEntity("reenablePaypalPayflowProPaymentWithVault", "test", "EnablePaypalPayflowProWithVault", [], []); // stepKey: reenablePaypalPayflowProPaymentWithVault
		$I->comment("New session should be started");
		$I->comment("Entering Action Group [logoutCustomerWithDefaultAddressAfterReenablePaymentMethod] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomerWithDefaultAddressAfterReenablePaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomerWithDefaultAddressAfterReenablePaymentMethod
		$I->comment("Exiting Action Group [logoutCustomerWithDefaultAddressAfterReenablePaymentMethod] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [customerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod
		$I->fillField("#email", $I->retrieveEntityField('customerWithDefaultAddress', 'email', 'test')); // stepKey: fillEmailCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod
		$I->fillField("#pass", $I->retrieveEntityField('customerWithDefaultAddress', 'password', 'test')); // stepKey: fillPasswordCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod
		$I->comment("Exiting Action Group [customerWithDefaultAddressLoginToStorefrontAfterReenablePaymentMethod] LoginToStorefrontActionGroup");
		$I->comment("15. Browse simple product page and check that Instant Purchase button show up");
		$I->comment("Entering Action Group [openSimpleProductPageWithReenabledPaymentMethod] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPageWithReenabledPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPageWithReenabledPaymentMethod
		$I->comment("Exiting Action Group [openSimpleProductPageWithReenabledPaymentMethod] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForElementVisible("button.instant-purchase", 30); // stepKey: waitForInstantPurchaseButtonWithReenabledPaymentMethod
		$I->comment("16. Disable shipping method for customer with default address");
		$disableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 0", 60); // stepKey: disableFlatRate
		$I->comment($disableFlatRate);
		$I->comment("New session should be started");
		$I->comment("Entering Action Group [logoutCustomerWithDefaultAddressAfterFlatRateDisabled] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomerWithDefaultAddressAfterFlatRateDisabled
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomerWithDefaultAddressAfterFlatRateDisabled
		$I->comment("Exiting Action Group [logoutCustomerWithDefaultAddressAfterFlatRateDisabled] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [customerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled
		$I->fillField("#email", $I->retrieveEntityField('customerWithDefaultAddress', 'email', 'test')); // stepKey: fillEmailCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled
		$I->fillField("#pass", $I->retrieveEntityField('customerWithDefaultAddress', 'password', 'test')); // stepKey: fillPasswordCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabledWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled
		$I->comment("Exiting Action Group [customerWithDefaultAddressLoginToStorefrontAfterFlatRateDisabled] LoginToStorefrontActionGroup");
		$I->comment("17. Browse simple product page and check that Instant Purchase button does not show up");
		$I->comment("Entering Action Group [openSimpleProductPageWhileFlatRateDisabled] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPageWhileFlatRateDisabled
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPageWhileFlatRateDisabled
		$I->comment("Exiting Action Group [openSimpleProductPageWhileFlatRateDisabled] StorefrontOpenProductEntityPageActionGroup");
		$I->dontSeeElement("button.instant-purchase"); // stepKey: dontSeeButtonOnSimpleProductPageWhileFlatRateDisabled
	}
}
