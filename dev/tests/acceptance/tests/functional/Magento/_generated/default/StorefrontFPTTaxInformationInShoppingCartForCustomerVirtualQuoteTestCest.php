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
 * @Title("MC-28585: Tax information are updating/recalculating on fly in shopping cart for Customer with default addresses (virtual quote)")
 * @Description("Tax information are updating/recalculating on fly in shopping cart for Customer with default addresses (virtual quote)<h3>Test files</h3>app/code/Magento/Weee/Test/Mftf/Test/StorefrontFPTTaxInformationInShoppingCartForCustomerVirtualQuoteTest.xml<br>")
 * @TestCaseId("MC-28585")
 * @group checkout
 * @group tax
 * @group weee
 */
class StorefrontFPTTaxInformationInShoppingCartForCustomerVirtualQuoteTestCest
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
		$I->createEntity("taxConfigurationCA", "hook", "Tax_Config_CA", [], []); // stepKey: taxConfigurationCA
		$I->comment("Virtual product is created:");
		$createVirtualProductFields['price'] = "40.00";
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", [], $createVirtualProductFields); // stepKey: createVirtualProduct
		$I->comment("Customer is created with default addresses:");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_NY", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$reindexBrokenIndices = $I->magentoCron("index", 90); // stepKey: reindexBrokenIndices
		$I->comment($reindexBrokenIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Need to logout first because otherwise selenium fail with timeout");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createTaxRule", "hook"); // stepKey: deleteTaxRule
		$I->deleteEntity("createProductFPTAttribute", "hook"); // stepKey: deleteProductFPTAttribute
		$I->createEntity("defaultTaxConfiguration", "hook", "DefaultTaxConfig", [], []); // stepKey: defaultTaxConfiguration
		$I->deleteEntity("createVirtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	public function StorefrontFPTTaxInformationInShoppingCartForCustomerVirtualQuoteTest(AcceptanceTester $I)
	{
		$I->comment("Test Steps");
		$I->comment("Step 1: Go to Storefront as logged in Customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Step 2: Add virtual product to shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnStorefrontVirtualProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [cartAddVirtualProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartCartAddVirtualProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartCartAddVirtualProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartCartAddVirtualProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartAddVirtualProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartAddVirtualProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddVirtualProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageCartAddVirtualProductToCart
		$I->see("You added " . $I->retrieveEntityField('createVirtualProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartAddVirtualProductToCart
		$I->comment("Exiting Action Group [cartAddVirtualProductToCart] AddToCartFromStorefrontProductPageActionGroup");
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
		$I->comment("Entering Action Group [checkAddress] AssertStorefrontCheckoutCartEstimateShippingAndTaxAddressActionGroup");
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']", 30); // stepKey: waitForSubtotalVisibleCheckAddress
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: expandEstimateShippingAndTaxIfNeededCheckAddress
		$I->waitForPageLoad(10); // stepKey: expandEstimateShippingAndTaxIfNeededCheckAddressWaitForPageLoad
		$I->seeOptionIsSelected("select[name='country_id']", "United States"); // stepKey: checkCountryCheckAddress
		$I->waitForPageLoad(10); // stepKey: checkCountryCheckAddressWaitForPageLoad
		$I->seeOptionIsSelected("select[name='region_id']", "New York"); // stepKey: checkStateCheckAddress
		$I->waitForPageLoad(10); // stepKey: checkStateCheckAddressWaitForPageLoad
		$grabPostCodeTextCheckAddress = $I->grabValueFrom("input[name='postcode']"); // stepKey: grabPostCodeTextCheckAddress
		$I->waitForPageLoad(10); // stepKey: grabPostCodeTextCheckAddressWaitForPageLoad
		$I->assertEquals("10001", $grabPostCodeTextCheckAddress, "Address postcode is invalid"); // stepKey: checkPostcodeCheckAddress
		$I->comment("Exiting Action Group [checkAddress] AssertStorefrontCheckoutCartEstimateShippingAndTaxAddressActionGroup");
		$I->comment("Entering Action Group [checkTaxAmountNY] AssertStorefrontCheckoutCartTaxAmountActionGroup");
		$I->see("$3.35", "[data-th='Tax']>span"); // stepKey: checkTaxAmountCheckTaxAmountNY
		$I->scrollTo(".totals-tax-summary"); // stepKey: scrollToTaxSummaryCheckTaxAmountNY
		$I->conditionalClick(".totals-tax-summary", " tr.totals-tax-details.shown th.mark", false); // stepKey: expandTaxSummaryCheckTaxAmountNY
		$I->see("US-NY-*-Rate 1 (8.375%)", " tr.totals-tax-details.shown th.mark"); // stepKey: checkRateCheckTaxAmountNY
		$I->comment("Exiting Action Group [checkTaxAmountNY] AssertStorefrontCheckoutCartTaxAmountActionGroup");
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
		$I->scrollTo("[data-th='Tax']>span"); // stepKey: scrollToTaxSummary
		$I->see("$0.00", "[data-th='Tax']>span"); // stepKey: checkTaxAmountZero
		$I->comment("Step 6: Change Data");
		$I->comment("Entering Action Group [setEstimateShippingAndTaxAddressToUnitedStates] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openEestimateShippingAndTaxSectionSetEstimateShippingAndTaxAddressToUnitedStates
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountrySetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectCountrySetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectStateSetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectStateSetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleSetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->fillField("input[name='postcode']", "90230"); // stepKey: selectPostCodeSetEstimateShippingAndTaxAddressToUnitedStates
		$I->waitForPageLoad(10); // stepKey: selectPostCodeSetEstimateShippingAndTaxAddressToUnitedStatesWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearSetEstimateShippingAndTaxAddressToUnitedStates
		$I->comment("Exiting Action Group [setEstimateShippingAndTaxAddressToUnitedStates] StorefrontCheckoutCartFillEstimateShippingAndTaxActionGroup");
		$I->comment("Entering Action Group [checkTaxAmountCA] AssertStorefrontCheckoutCartTaxAmountActionGroup");
		$I->see("$3.30", "[data-th='Tax']>span"); // stepKey: checkTaxAmountCheckTaxAmountCA
		$I->scrollTo(".totals-tax-summary"); // stepKey: scrollToTaxSummaryCheckTaxAmountCA
		$I->conditionalClick(".totals-tax-summary", " tr.totals-tax-details.shown th.mark", false); // stepKey: expandTaxSummaryCheckTaxAmountCA
		$I->see("US-CA-*-Rate 1 (8.25%)", " tr.totals-tax-details.shown th.mark"); // stepKey: checkRateCheckTaxAmountCA
		$I->comment("Exiting Action Group [checkTaxAmountCA] AssertStorefrontCheckoutCartTaxAmountActionGroup");
	}
}
