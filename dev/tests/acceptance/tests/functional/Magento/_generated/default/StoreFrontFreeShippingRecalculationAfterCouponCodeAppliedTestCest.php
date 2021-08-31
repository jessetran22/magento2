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
 * @Title("MC-28548: Checkout Free Shipping Recalculation after Coupon Code Added")
 * @Description("User should be able to do checkout free shipping recalculation after adding coupon code<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StoreFrontFreeShippingRecalculationAfterCouponCodeAppliedTest.xml<br>")
 * @TestCaseId("MC-28548")
 * @group Checkout
 */
class StoreFrontFreeShippingRecalculationAfterCouponCodeAppliedTestCest
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
		$createCustomerFields['group_id'] = "1";
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], $createCustomerFields); // stepKey: createCustomer
		$I->createEntity("defaultCategory", "hook", "_defaultCategory", [], []); // stepKey: defaultCategory
		$simpleProductFields['price'] = "90";
		$I->createEntity("simpleProduct", "hook", "_defaultProduct", ["defaultCategory"], $simpleProductFields); // stepKey: simpleProduct
		$I->comment("It is default for FlatRate");
		$I->createEntity("enableFlatRate", "hook", "FlatRateShippingMethodConfig", [], []); // stepKey: enableFlatRate
		$I->createEntity("freeShippingMethodsSettingConfig", "hook", "FreeShippingMethodsSettingConfig", [], []); // stepKey: freeShippingMethodsSettingConfig
		$I->createEntity("minimumOrderAmount90", "hook", "MinimumOrderAmount90", [], []); // stepKey: minimumOrderAmount90
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
		$I->comment("Entering Action Group [deleteAllCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: goToAdminCartPriceRuleGridPageDeleteAllCartPriceRules
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCartPriceRules
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCartPriceRules
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCartPriceRulesWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCartPriceRules] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCartPriceRules
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCartPriceRules
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCartPriceRules
		$I->comment("Exiting Action Group [deleteAllCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->comment("Entering Action Group [createCartPriceRule] AdminCreateCartPriceRuleWithCouponCodeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateCartPriceRule
		$I->click("#add"); // stepKey: clickAddNewRuleCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateCartPriceRule
		$I->fillField("input[name='name']", "CartPriceRule" . msq("CatPriceRule")); // stepKey: fillRuleNameCreateCartPriceRule
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponTypeCreateCartPriceRule
		$I->waitForElementVisible("input[name='coupon_code']", 30); // stepKey: waitForElementVisibleCreateCartPriceRule
		$I->fillField("input[name='coupon_code']", "CouponCode" . msq("CatPriceRule")); // stepKey: fillCouponCodeCreateCartPriceRule
		$I->fillField("//input[@name='uses_per_coupon']", "99"); // stepKey: fillUserPerCouponCreateCartPriceRule
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateCartPriceRule
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN',  'General',  'Wholesale',  'Retailer']); // stepKey: selectCustomerGroupCreateCartPriceRule
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateCartPriceRuleWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Fixed amount discount for whole cart"); // stepKey: selectActionTypeToFixedCreateCartPriceRule
		$I->fillField("input[name='discount_amount']", "1"); // stepKey: fillDiscountAmountCreateCartPriceRule
		$I->click("#save"); // stepKey: clickSaveButtonCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateCartPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateCartPriceRule
		$I->comment("Exiting Action Group [createCartPriceRule] AdminCreateCartPriceRuleWithCouponCodeActionGroup");
		$I->comment("Entering Action Group [loginToStoreFront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStoreFront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStoreFront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStoreFront
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'hook')); // stepKey: fillEmailLoginToStoreFront
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'hook')); // stepKey: fillPasswordLoginToStoreFront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStoreFront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStoreFrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStoreFront
		$I->comment("Exiting Action Group [loginToStoreFront] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("defaultCategory", "hook"); // stepKey: deleteCategory
		$I->createEntity("defaultShippingMethodsConfig", "hook", "DefaultShippingMethodsConfig", [], []); // stepKey: defaultShippingMethodsConfig
		$I->createEntity("defaultMinimumOrderAmount", "hook", "DefaultMinimumOrderAmount", [], []); // stepKey: defaultMinimumOrderAmount
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [deleteAllCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: goToAdminCartPriceRuleGridPageDeleteAllCartPriceRules
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCartPriceRules
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCartPriceRules
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCartPriceRulesWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCartPriceRules] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCartPriceRules
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCartPriceRules
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCartPriceRules
		$I->comment("Exiting Action Group [deleteAllCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
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
	 * @Features({"Checkout"})
	 * @Stories({"Checkout Free Shipping Recalculation after Coupon Code Added"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontFreeShippingRecalculationAfterCouponCodeAppliedTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [applyCartRule] ApplyCartRuleOnStorefrontActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartApplyCartRule
		$I->waitForPageLoad(60); // stepKey: addToCartApplyCartRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartApplyCartRule
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageApplyCartRule
		$I->waitForText("You added " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to your shopping cart.", 30); // stepKey: waitForTextApplyCartRule
		$I->amOnPage("/checkout/cart"); // stepKey: goToCheckoutPageApplyCartRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1ApplyCartRule
		$I->click("//*[text()='Apply Discount Code']"); // stepKey: clickToDiscountTabApplyCartRule
		$I->fillField("#coupon_code", "CouponCode" . msq("CatPriceRule")); // stepKey: fillCouponCodeApplyCartRule
		$I->click("//span[text()='Apply Discount']"); // stepKey: applyCodeApplyCartRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ApplyCartRule
		$I->comment("Exiting Action Group [applyCartRule] ApplyCartRuleOnStorefrontActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart1] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart1
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart1
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart1
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicart1WaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart1
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicart1WaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart1] GoToCheckoutFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForpageLoad1
		$I->dontSee("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free')]/.."); // stepKey: dontSeeFreeShipping
		$I->comment("Entering Action Group [goToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToShoppingCartPage
		$I->comment("Exiting Action Group [goToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: openDiscountTabIfClosed
		$I->waitForPageLoad(30); // stepKey: waitForCouponTabOpen1
		$I->click("//button[@value='Cancel Coupon']"); // stepKey: cancelCoupon
		$I->waitForPageLoad(30); // stepKey: waitForCancel
		$I->see("You canceled the coupon code."); // stepKey: seeCancellationMessage
		$I->comment("Entering Action Group [goToCheckoutFromMinicart2] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart2
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart2
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart2
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicart2WaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart2
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicart2WaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart2] GoToCheckoutFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethods
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free')]/.."); // stepKey: chooseFreeShipping
		$I->comment("Entering Action Group [clickNextAfterFreeShippingMethodSelection] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextAfterFreeShippingMethodSelection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextAfterFreeShippingMethodSelectionWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNextAfterFreeShippingMethodSelection
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextAfterFreeShippingMethodSelectionWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNextAfterFreeShippingMethodSelection
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextAfterFreeShippingMethodSelectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNextAfterFreeShippingMethodSelection
		$I->comment("Exiting Action Group [clickNextAfterFreeShippingMethodSelection] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForReviewAndPayments
		$I->comment("Entering Action Group [applyCouponCode] StorefrontApplyDiscountCodeActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountApplyCouponCode
		$I->fillField("#discount-code", "CouponCode" . msq("CatPriceRule")); // stepKey: fillFieldDiscountCodeApplyCouponCode
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscountApplyCouponCode
		$I->waitForElementVisible(".message-success div", 30); // stepKey: waitForDiscountToBeAddedApplyCouponCode
		$I->see("Your coupon was successfully applied", ".message-success div"); // stepKey: assertDiscountApplyMessageApplyCouponCode
		$I->comment("Exiting Action Group [applyCouponCode] StorefrontApplyDiscountCodeActionGroup");
		$I->comment("Assert order cannot be placed and error message will shown.");
		$I->comment("Entering Action Group [seeShippingMethodError] AssertStorefrontOrderIsNotPlacedActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonSeeShippingMethodError
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonSeeShippingMethodErrorWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderSeeShippingMethodError
		$I->waitForElement(".message-error.error.message>div", 30); // stepKey: waitForErrorMessageSeeShippingMethodError
		$I->seeElementInDOM("//div[contains(@class, 'message message-error error')]//div[contains(text(), 'The shipping method is missing. Select the shipping method and try again.')]"); // stepKey: assertErrorMessageInDOMSeeShippingMethodError
		$I->comment("Exiting Action Group [seeShippingMethodError] AssertStorefrontOrderIsNotPlacedActionGroup");
		$I->amOnPage("/checkout/#shipping"); // stepKey: navigateToShippingPage
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoad
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/.."); // stepKey: chooseFlatRateShipping
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [clickNextAfterFlatRateShippingMethodSelection] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextAfterFlatRateShippingMethodSelection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextAfterFlatRateShippingMethodSelectionWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNextAfterFlatRateShippingMethodSelection
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextAfterFlatRateShippingMethodSelectionWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNextAfterFlatRateShippingMethodSelection
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextAfterFlatRateShippingMethodSelectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNextAfterFlatRateShippingMethodSelection
		$I->comment("Exiting Action Group [clickNextAfterFlatRateShippingMethodSelection] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Entering Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPaymentMethod
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectPaymentMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPaymentMethod
		$I->comment("Exiting Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Place Order");
		$I->comment("Entering Action Group [placeOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouPlaceOrder
		$I->comment("Exiting Action Group [placeOrder] CheckoutPlaceOrderActionGroup");
	}
}
