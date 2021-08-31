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
 * @Title("MC-28592: Tax information are updating/recalculating on fly in shopping cart for Guest (physical quote)")
 * @Description("Tax information are updating/recalculating on fly in shopping cart for Guest (physical quote)<h3>Test files</h3>app/code/Magento/Weee/Test/Mftf/Test/StorefrontFPTTaxInformationInShoppingCartForGuestPhysicalQuoteTest.xml<br>")
 * @TestCaseId("MC-28592")
 * @group checkout
 * @group tax
 * @group weee
 */
class StorefrontFPTTaxInformationInShoppingCartForGuestPhysicalQuoteTestCest
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
		$I->comment("Preconditions");
		$I->comment("Tax Rule is created based on default tax rates (Stores>Tax Rule) US-CA-*-Rate 1 = 8.2500 US-NY-*-Rate 1 = 8.3750");
		$I->createEntity("createTaxRule", "hook", "SimpleTaxRule", [], []); // stepKey: createTaxRule
		$I->comment("Fixed Product Tax attribute is created and added to default attribute set");
		$I->createEntity("createProductFPTAttribute", "hook", "FPTProductAttribute", [], []); // stepKey: createProductFPTAttribute
		$I->createEntity("addFPTToAttributeSet", "hook", "AddToDefaultSet", ["createProductFPTAttribute"], []); // stepKey: addFPTToAttributeSet
		$I->comment("Tax configuration (Store>Configuration; Sales>Tax)");
		$I->createEntity("taxConfigurationForCA", "hook", "Tax_Config_CA", [], []); // stepKey: taxConfigurationForCA
		$I->comment("Store>Configuration; Sales>Tax FPT Enable");
		$I->createEntity("enableFPT", "hook", "WeeeConfigEnable", [], []); // stepKey: enableFPT
		$I->comment("Simple product is created  Price = 10;  FPT United States/California/10,United States/New York/20");
		$createSimpleProductFields['price'] = "10.00";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'hook')); // stepKey: goToProductOpenProductEditPage
		$I->comment("Exiting Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addFPTValue1] AdminProductAddFPTValueActionGroup");
		$I->click("[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] [data-action='add_new_row']"); // stepKey: clickAddFPTButton1AddFPTValue1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFPTValue1
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child select[name*='[country]']", "US"); // stepKey: selectcountryForFPTAddFPTValue1
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child select[name*='[state]']", "California"); // stepKey: selectstateForFPTAddFPTValue1
		$I->fillField("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child input[name*='[value]']", "10"); // stepKey: setTaxvalueForFPTAddFPTValue1
		$I->comment("Exiting Action Group [addFPTValue1] AdminProductAddFPTValueActionGroup");
		$I->comment("Entering Action Group [addFPTValue2] AdminProductAddFPTValueActionGroup");
		$I->click("[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] [data-action='add_new_row']"); // stepKey: clickAddFPTButton1AddFPTValue2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFPTValue2
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child select[name*='[country]']", "US"); // stepKey: selectcountryForFPTAddFPTValue2
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child select[name*='[state]']", "New York"); // stepKey: selectstateForFPTAddFPTValue2
		$I->fillField("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child input[name*='[value]']", "20"); // stepKey: setTaxvalueForFPTAddFPTValue2
		$I->comment("Exiting Action Group [addFPTValue2] AdminProductAddFPTValueActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$reindexBrokenIndices = $I->magentoCron("index", 90); // stepKey: reindexBrokenIndices
		$I->comment($reindexBrokenIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createTaxRule", "hook"); // stepKey: deleteTaxRule
		$I->deleteEntity("createProductFPTAttribute", "hook"); // stepKey: deleteProductFPTAttribute
		$I->createEntity("defaultTaxConfiguration", "hook", "DefaultTaxConfig", [], []); // stepKey: defaultTaxConfiguration
		$I->createEntity("disableFPT", "hook", "WeeeConfigDisable", [], []); // stepKey: disableFPT
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$reindexBrokenIndices = $I->magentoCron("index", 90); // stepKey: reindexBrokenIndices
		$I->comment($reindexBrokenIndices);
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
	 * @Features({"Weee"})
	 * @Stories({"Shopping cart taxes"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontFPTTaxInformationInShoppingCartForGuestPhysicalQuoteTest(AcceptanceTester $I)
	{
		$I->comment("Test Steps");
		$I->comment("Step 1: Go to Storefront as Guest");
		$I->comment("Step 2: Add simple product to shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartCartAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageCartAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartAddSimpleProductToCart
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Step 3: Go to Shopping Cart");
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
		$I->comment("Step 4: Open Estimate Shipping and Tax section");
		$I->comment("Entering Action Group [setEstimateShippingAndTaxInitialAddressToUnitedStates] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openEestimateShippingAndTaxSectionSetEstimateShippingAndTaxInitialAddressToUnitedStates
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountrySetEstimateShippingAndTaxInitialAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectCountrySetEstimateShippingAndTaxInitialAddressToUnitedStatesWaitForPageLoad
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectStateSetEstimateShippingAndTaxInitialAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectStateSetEstimateShippingAndTaxInitialAddressToUnitedStatesWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxInitialAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxInitialAddressToUnitedStatesWaitForPageLoad
		$I->fillField("input[name='postcode']", "*"); // stepKey: selectPostCodeSetEstimateShippingAndTaxInitialAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectPostCodeSetEstimateShippingAndTaxInitialAddressToUnitedStatesWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearSetEstimateShippingAndTaxInitialAddressToUnitedStates
		$I->comment("Exiting Action Group [setEstimateShippingAndTaxInitialAddressToUnitedStates] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->comment("Entering Action Group [checkTaxAmountCA] AssertStorefrontCheckoutCartTaxAmountFPTActionGroup");
		$I->see("$10", ".totals td[data-th='FPT'] .price"); // stepKey: checkFPTAmountCheckTaxAmountCA
		$I->see("$0.83", "[data-th='Tax']>span"); // stepKey: checkTaxAmountCheckTaxAmountCA
		$I->scrollTo(".totals-tax-summary"); // stepKey: scrollToTaxSummaryCheckTaxAmountCA
		$I->conditionalClick(".totals-tax-summary", " tr.totals-tax-details.shown th.mark", false); // stepKey: expandTaxSummaryCheckTaxAmountCA
		$I->see("US-CA-*-Rate 1 (8.25%)", " tr.totals-tax-details.shown th.mark"); // stepKey: checkRateCheckTaxAmountCA
		$I->comment("Exiting Action Group [checkTaxAmountCA] AssertStorefrontCheckoutCartTaxAmountFPTActionGroup");
		$I->comment("Step 5: Change Data");
		$I->comment("Entering Action Group [setEstimateShippingAndTaxAddressToSwitzerland] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openEestimateShippingAndTaxSectionSetEstimateShippingAndTaxAddressToSwitzerland
		$I->selectOption("select[name='country_id']", "Switzerland"); // stepKey: selectCountrySetEstimateShippingAndTaxAddressToSwitzerland
		$I->waitForPageLoad(10); // stepKey: selectCountrySetEstimateShippingAndTaxAddressToSwitzerlandWaitForPageLoad
		$I->selectOption("select[name='region_id']", "Aargau"); // stepKey: selectStateSetEstimateShippingAndTaxAddressToSwitzerland
		$I->waitForPageLoad(10); // stepKey: selectStateSetEstimateShippingAndTaxAddressToSwitzerlandWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxAddressToSwitzerland
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxAddressToSwitzerlandWaitForPageLoad
		$I->fillField("input[name='postcode']", "1234"); // stepKey: selectPostCodeSetEstimateShippingAndTaxAddressToSwitzerland
		$I->waitForPageLoad(10); // stepKey: selectPostCodeSetEstimateShippingAndTaxAddressToSwitzerlandWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearSetEstimateShippingAndTaxAddressToSwitzerland
		$I->comment("Exiting Action Group [setEstimateShippingAndTaxAddressToSwitzerland] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->comment("Step 6: Select shipping rate again(it need for get new totals request - performance reason)");
		$I->click("#s_method_flatrate_flatrate"); // stepKey: selectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: selectFlatRateShippingMethodWaitForPageLoad
		$I->scrollTo("[data-th='Tax']>span"); // stepKey: scrollToTaxSummary
		$I->see("$0.00", "[data-th='Tax']>span"); // stepKey: checkTaxAmountZero
		$I->dontSeeElement(".totals td[data-th='FPT'] .price"); // stepKey: checkFPTIsNotDisplayed
		$I->comment("Step 7: Change Data");
		$I->comment("Entering Action Group [setEstimateShippingAndTaxAddressToUnitedStates] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openEestimateShippingAndTaxSectionSetEstimateShippingAndTaxAddressToUnitedStates
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountrySetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectCountrySetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->selectOption("select[name='region_id']", "New York"); // stepKey: selectStateSetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectStateSetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->fillField("input[name='postcode']", "12345"); // stepKey: selectPostCodeSetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectPostCodeSetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearSetEstimateShippingAndTaxAddressToUnitedStates
		$I->comment("Exiting Action Group [setEstimateShippingAndTaxAddressToUnitedStates] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->comment("Step 8: Select shipping rate again(it need for get new totals request - performance reason)");
		$I->click("#s_method_flatrate_flatrate"); // stepKey: selectFlatRateShippingMethodAgain
		$I->waitForPageLoad(30); // stepKey: selectFlatRateShippingMethodAgainWaitForPageLoad
		$I->comment("Entering Action Group [checkTaxAmountNY] AssertStorefrontCheckoutCartTaxAmountFPTActionGroup");
		$I->see("$20", ".totals td[data-th='FPT'] .price"); // stepKey: checkFPTAmountCheckTaxAmountNY
		$I->see("$0.84", "[data-th='Tax']>span"); // stepKey: checkTaxAmountCheckTaxAmountNY
		$I->scrollTo(".totals-tax-summary"); // stepKey: scrollToTaxSummaryCheckTaxAmountNY
		$I->conditionalClick(".totals-tax-summary", " tr.totals-tax-details.shown th.mark", false); // stepKey: expandTaxSummaryCheckTaxAmountNY
		$I->see("US-NY-*-Rate 1 (8.375%)", " tr.totals-tax-details.shown th.mark"); // stepKey: checkRateCheckTaxAmountNY
		$I->comment("Exiting Action Group [checkTaxAmountNY] AssertStorefrontCheckoutCartTaxAmountFPTActionGroup");
	}
}
