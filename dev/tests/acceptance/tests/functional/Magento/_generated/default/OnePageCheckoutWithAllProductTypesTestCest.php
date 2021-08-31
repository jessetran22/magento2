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
 * @Title("MC-14742: OnePageCheckout with all product types test")
 * @Description("Checkout with all product types<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/OnePageCheckoutWithAllProductTypesTest.xml<br>")
 * @TestCaseId("MC-14742")
 * @group checkout
 * @group mtf_migrated
 */
class OnePageCheckoutWithAllProductTypesTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create Configurable Product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption
		$I->createEntity("createConfigChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption", "createCategory"], []); // stepKey: createConfigChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct"], []); // stepKey: createConfigProductAddChild
		$I->comment("Create Bundle Product");
		$I->createEntity("createSimpleProductForBundleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProductForBundleProduct
		$I->createEntity("createFixedBundleProduct", "hook", "ApiFixedBundleProduct", [], []); // stepKey: createFixedBundleProduct
		$I->createEntity("createBundleOption", "hook", "DropDownBundleOption", ["createFixedBundleProduct"], []); // stepKey: createBundleOption
		$I->createEntity("firstLinkOptionToFixedProduct", "hook", "ApiBundleLink", ["createFixedBundleProduct", "createBundleOption", "createSimpleProductForBundleProduct"], []); // stepKey: firstLinkOptionToFixedProduct
		$I->comment("Create Virtual Product");
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", [], []); // stepKey: createVirtualProduct
		$I->comment("Create Downloadable Product");
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], []); // stepKey: createDownloadableProduct
		$I->createEntity("addDownloadableLink", "hook", "ApiDownloadableLink", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink
		$I->createEntity("addDownloadableLink1", "hook", "ApiDownloadableLink", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink1
		$I->comment("Create Grouped Product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct", [], []); // stepKey: createGroupedProduct
		$I->createEntity("addProductOne", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createSimpleProduct"], []); // stepKey: addProductOne
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete all created products");
		$I->deleteEntity("createConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createSimpleProductForBundleProduct", "hook"); // stepKey: deleteSimpleProductForBundleProduct
		$I->deleteEntity("createFixedBundleProduct", "hook"); // stepKey: deleteFixedBundleProduct
		$I->deleteEntity("createVirtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->deleteEntity("createDownloadableProduct", "hook"); // stepKey: deleteDownloadableProduct
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
		$I->comment("BIC workaround");
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront
		$I->comment("Exiting Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCreatedCustomer
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
	 * @Features({"Checkout"})
	 * @Stories({"OnePageCheckout within Offline Payment Methods"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function OnePageCheckoutWithAllProductTypesTest(AcceptanceTester $I)
	{
		$I->comment("Add Simple Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Add Configurable Product to cart");
		$I->comment("Entering Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
		$I->amOnPage($I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontPageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductFrontPageToLoadAddConfigurableProductToCart
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption', 'value', 'test')); // stepKey: selectOption1AddConfigurableProductToCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProductQuantityAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: fillProductQuantityAddConfigurableProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddConfigurableProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddConfigurableProductToCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCartWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
		$I->comment("Add Virtual Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToVirtualProductPage
		$I->waitForPageLoad(30); // stepKey: waitForVirtualProductPageLoad
		$I->comment("Entering Action Group [addToCartVirtualProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createVirtualProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartVirtualProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Add Downloadable Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToDownloadableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForDownloadableProductPageLoad
		$I->comment("Entering Action Group [addToCartDownloadableProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartDownloadableProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartDownloadableProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartDownloadableProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartDownloadableProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartDownloadableProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartDownloadableProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartDownloadableProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartDownloadableProductFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartDownloadableProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Add Grouped Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToGroupedProductPage
		$I->waitForPageLoad(30); // stepKey: waitForGroupedProductPageLoad
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillFieldQtyInput
		$I->waitForPageLoad(30); // stepKey: fillFieldQtyInputWaitForPageLoad
		$I->comment("Entering Action Group [addToCartGroupedProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartGroupedProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartGroupedProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartGroupedProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartGroupedProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartGroupedProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartGroupedProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartGroupedProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createGroupedProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartGroupedProductFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartGroupedProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Add Bundle Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createFixedBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToBundleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForFixedBundleProductPageLoad
		$I->comment("Entering Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeAndAddToCart
		$I->comment("Exiting Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [addToCartFixedBundleProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFixedBundleProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFixedBundleProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFixedBundleProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFixedBundleProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFixedBundleProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFixedBundleProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFixedBundleProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createFixedBundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFixedBundleProductFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFixedBundleProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to shopping cart");
		$I->comment("Entering Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartFromMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartFromMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartFromMinicart
		$I->comment("Exiting Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Entering Action Group [fillShippingZipForm] FillShippingZipForm");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: openShippingDetailsFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: openShippingDetailsFillShippingZipFormWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillShippingZipForm
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForCountryFieldAppearsFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: waitForCountryFieldAppearsFillShippingZipFormWaitForPageLoad
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountryFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: selectCountryFillShippingZipFormWaitForPageLoad
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectStateProvinceFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: selectStateProvinceFillShippingZipFormWaitForPageLoad
		$I->fillField("input[name='postcode']", "90001"); // stepKey: fillPostCodeFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: fillPostCodeFillShippingZipFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFormUpdateFillShippingZipForm
		$I->comment("Exiting Action Group [fillShippingZipForm] FillShippingZipForm");
		$I->comment("Entering Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutClickProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutClickProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickProceedToCheckout
		$I->comment("Exiting Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForProceedToCheckout action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [fillCustomerSignInPopupForm] FillCustomerSignInPopupFormActionGroup");
		$I->waitForElementVisible("#customer-email", 30); // stepKey: waitEmailFieldVisibleFillCustomerSignInPopupForm
		$I->fillField("#customer-email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillCustomerEmailFillCustomerSignInPopupForm
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillCustomerPasswordFillCustomerSignInPopupForm
		$I->click("#send2"); // stepKey: clickSignInFillCustomerSignInPopupForm
		$I->waitForPageLoad(30); // stepKey: clickSignInFillCustomerSignInPopupFormWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerSignInPopupForm] FillCustomerSignInPopupFormActionGroup");
		$I->amOnPage("/checkout/#shipping"); // stepKey: navigateToShippingPage
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoad
		$I->comment("Fill customer address data");
		$I->fillField("input[name=company]", "Magento"); // stepKey: fillCompany
		$I->fillField("input[name='street[0]']", "[\"7700 W Parmer Ln\",\"Bld D\"]"); // stepKey: fillStreet
		$I->fillField("input[name=city]", "Austin"); // stepKey: fillCity
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegion
		$I->fillField("input[name=postcode]", "78729"); // stepKey: fillZipCode
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: fillPhone
		$I->comment("Click next button to open payment section");
		$I->comment("Entering Action Group [clickNextBtn] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNextBtn
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextBtnWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedClickNextBtn
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlClickNextBtn
		$I->comment("Exiting Action Group [clickNextBtn] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Check order summary in checkout");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoaded
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderButton
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderButtonWaitForPageLoad
		$I->seeElement("div.checkout-success"); // stepKey: orderIsSuccessfullyPlaced
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Open created order");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [filterOrderGridById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderNumber"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageFilterOrderGridById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] OpenOrderByIdActionGroup");
		$I->comment("Assert that addresses on order page the same");
		$shippingAddressOrderPage = $I->grabTextFrom(".order-shipping-address address"); // stepKey: shippingAddressOrderPage
		$billingAddressOrderPage = $I->grabTextFrom(".order-billing-address address"); // stepKey: billingAddressOrderPage
		$I->assertEquals($shippingAddressOrderPage, $billingAddressOrderPage); // stepKey: assertAddressOrderPage
		$I->comment("Assert order total");
		$I->comment("Entering Action Group [navigateToCustomerDashboardPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageNavigateToCustomerDashboardPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCustomerDashboardPage
		$I->comment("Exiting Action Group [navigateToCustomerDashboardPage] StorefrontOpenMyAccountPageActionGroup");
		$I->see("$613.23", ".total .price"); // stepKey: checkOrderTotalInStorefront
		$I->comment("Go to Address Book");
		$I->comment("Entering Action Group [goToAddressBook] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Address Book']"); // stepKey: goToAddressBookGoToAddressBook
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToAddressBookWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToAddressBook
		$I->comment("Exiting Action Group [goToAddressBook] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Asserts that addresses in address book equal to addresses in order");
		$shippingAddress = $I->grabTextFrom("//*[@class='box box-address-shipping']//address"); // stepKey: shippingAddress
		$billingAddress = $I->grabTextFrom("//*[@class='box box-address-billing']//address"); // stepKey: billingAddress
		$I->assertEquals($shippingAddressOrderPage, $shippingAddress); // stepKey: assertShippingAddress
		$I->assertEquals($billingAddressOrderPage, $billingAddress); // stepKey: assertBillingAddress
	}
}
