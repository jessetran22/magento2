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
 * @Title("MC-15604: Create Cart Price Rule And Verify Rule Condition And Free Shipping Is Applied")
 * @Description("Test log in to Cart Price Rules and Create Cart Price Rule And Verify Rule Condition And Free Shipping Is Applied<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminCreateCartPriceRuleAndVerifyRuleConditionAndFreeShippingIsAppliedTest.xml<br>")
 * @TestCaseId("MC-15604")
 * @group SalesRule
 * @group mtf_migrated
 */
class AdminCreateCartPriceRuleAndVerifyRuleConditionAndFreeShippingIsAppliedTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("initialSimpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: initialSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteCreatedCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteCreatedCartPriceRule
		$I->fillField("input[name='name']", "Cart Price Rule For RuleCondition And FreeShipping" . msq("CartPriceRuleConditionAndFreeShippingApplied")); // stepKey: filterByNameDeleteCreatedCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCreatedCartPriceRule] DeleteCartPriceRuleByName");
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
	 * @Stories({"Create Sales Rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"SalesRule"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCartPriceRuleAndVerifyRuleConditionAndFreeShippingIsAppliedTest(AcceptanceTester $I)
	{
		$I->comment("Create cart price rule as per data and verify AssertCartPriceRuleSuccessSaveMessage");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->fillField("input[name='name']", "Cart Price Rule For RuleCondition And FreeShipping" . msq("CartPriceRuleConditionAndFreeShippingApplied")); // stepKey: fillRuleName
		$I->fillField("//div[@class='admin__field-control']/textarea[@name='description']", "Description for Cart Price Rule"); // stepKey: fillDescription
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsites
		$I->selectOption("select[name='customer_group_ids']", ["NOT LOGGED IN"]); // stepKey: selectCustomerGroup
		$I->selectOption("select[name='coupon_type']", "No Coupon"); // stepKey: selectCouponType
		$I->scrollTo("div[data-index='actions']"); // stepKey: scrollToActionsHeader
		$I->waitForPageLoad(30); // stepKey: scrollToActionsHeaderWaitForPageLoad
		$I->comment("Entering Action Group [createActiveCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->conditionalClick("div[data-index='actions']", "div[data-index='actions']", true); // stepKey: clickToExpandActionsCreateActiveCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateActiveCartPriceRuleActionsSectionWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_amount']", "50"); // stepKey: fillDiscountAmountCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_qty']", "0"); // stepKey: fillMaximumQtyDiscountCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_step']", "0"); // stepKey: fillDiscountStepCreateActiveCartPriceRuleActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->comment("Entering Action Group [createActiveCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->selectOption("//select[@name='simple_free_shipping']", "For matching items only"); // stepKey: selectForMatchingItemsOnlyCreateActiveCartPriceRuleFreeShippingActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->comment("Entering Action Group [createActiveCartPriceRuleLabelsSection] AdminCreateCartPriceRuleLabelsSectionActionGroup");
		$I->conditionalClick("div[data-index='labels']", "div[data-index='labels']", true); // stepKey: clickToExpandLabelsCreateActiveCartPriceRuleLabelsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandLabelsCreateActiveCartPriceRuleLabelsSectionWaitForPageLoad
		$I->fillField("input[name='store_labels[0]']", "Free Shipping in conditions"); // stepKey: fillDefaultRuleLabelAllStoreViewsCreateActiveCartPriceRuleLabelsSection
		$I->fillField("input[name='store_labels[1]']", "Free Shipping in conditions"); // stepKey: fillDefaultStoreViewCreateActiveCartPriceRuleLabelsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleLabelsSection] AdminCreateCartPriceRuleLabelsSectionActionGroup");
		$I->comment("Entering Action Group [seeAssertCartPriceRuleSuccessSaveMessage] AssertCartPriceRuleSuccessSaveMessageActionGroup");
		$I->click("#save"); // stepKey: clickSaveButtonSeeAssertCartPriceRuleSuccessSaveMessage
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSeeAssertCartPriceRuleSuccessSaveMessageWaitForPageLoad
		$I->see("You saved the rule.", "div.message.message-success.success"); // stepKey: seeAssertSuccessSaveMessageSeeAssertCartPriceRuleSuccessSaveMessage
		$I->comment("Exiting Action Group [seeAssertCartPriceRuleSuccessSaveMessage] AssertCartPriceRuleSuccessSaveMessageActionGroup");
		$I->comment("Search created cart price rule in grid");
		$I->comment("Entering Action Group [searchCreatedCartPriceRuleInGrid] AdminFilterCartPriceRuleActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchCreatedCartPriceRuleInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchCreatedCartPriceRuleInGridWaitForPageLoad
		$I->fillField("input[name='name']", "Cart Price Rule For RuleCondition And FreeShipping" . msq("CartPriceRuleConditionAndFreeShippingApplied")); // stepKey: filterByNameSearchCreatedCartPriceRuleInGrid
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterSearchCreatedCartPriceRuleInGrid
		$I->waitForPageLoad(30); // stepKey: doFilterSearchCreatedCartPriceRuleInGridWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageSearchCreatedCartPriceRuleInGrid
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageSearchCreatedCartPriceRuleInGridWaitForPageLoad
		$I->comment("Exiting Action Group [searchCreatedCartPriceRuleInGrid] AdminFilterCartPriceRuleActionGroup");
		$I->comment("Go to cart price rule form page and verify AssertCartPriceRuleForm");
		$I->waitForPageLoad(30); // stepKey: waitForAdminCartPriceRuleEditPageLoad
		$I->seeInField("input[name='name']", "Cart Price Rule For RuleCondition And FreeShipping" . msq("CartPriceRuleConditionAndFreeShippingApplied")); // stepKey: seeRuleName
		$I->seeInField("//div[@class='admin__field-control']/textarea[@name='description']", "Description for Cart Price Rule"); // stepKey: seeDescription
		$I->seeInField("select[name='website_ids']", "Main Website"); // stepKey: seeWebsites
		$I->seeInField("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: seeCustomerGroup
		$I->seeInField("select[name='coupon_type']", "No Coupon"); // stepKey: seeCouponType
		$I->scrollTo("div[data-index='actions']"); // stepKey: clickActionsHeader
		$I->waitForPageLoad(30); // stepKey: clickActionsHeaderWaitForPageLoad
		$I->conditionalClick("div[data-index='actions']", "div[data-index='actions']", true); // stepKey: clickExpandActions
		$I->waitForPageLoad(30); // stepKey: clickExpandActionsWaitForPageLoad
		$I->see("Percent of product price discount", "select[name='simple_action']"); // stepKey: seeActionApplyType
		$I->seeInField("input[name='discount_amount']", "50"); // stepKey: seeDiscountAmount
		$I->seeInField("//select[@name='simple_free_shipping']", "For matching items only"); // stepKey: seeFreeShipping
		$I->scrollTo("div[data-index='labels']"); // stepKey: clickLabelsHeader
		$I->waitForPageLoad(30); // stepKey: clickLabelsHeaderWaitForPageLoad
		$I->conditionalClick("div[data-index='labels']", "div[data-index='labels']", true); // stepKey: clickToExpandLabels
		$I->waitForPageLoad(30); // stepKey: clickToExpandLabelsWaitForPageLoad
		$I->seeInField("input[name='store_labels[0]']", "Free Shipping in conditions"); // stepKey: seeDefaultRuleLabelAllStoreViews
		$I->seeInField("input[name='store_labels[1]']", "Free Shipping in conditions"); // stepKey: seeDefaultStoreView
		$I->comment("Go to storefront page and verify created product");
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('initialSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('initialSimpleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('initialSimpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('initialSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Click on Add To Cart button");
		$I->comment("Entering Action Group [clickOnAddToCartButton] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnAddToCartButton
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonClickOnAddToCartButton
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonClickOnAddToCartButtonWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartClickOnAddToCartButton
		$I->waitForPageLoad(60); // stepKey: addToCartClickOnAddToCartButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnAddToCartButton
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageClickOnAddToCartButton
		$I->comment("Exiting Action Group [clickOnAddToCartButton] StorefrontAddToTheCartActionGroup");
		$I->comment("Click on mini cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Open mini cart and verify Shopping cart subtotal equals to grand total");
		$I->comment("Entering Action Group [verifyCartSubtotalEqualsGrandTotal] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$560.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartVerifyCartSubtotalEqualsGrandTotalWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('initialSimpleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1VerifyCartSubtotalEqualsGrandTotal
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageVerifyCartSubtotalEqualsGrandTotal
		$I->see("$560.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalVerifyCartSubtotalEqualsGrandTotal
		$I->see($I->retrieveEntityField('initialSimpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->comment("Exiting Action Group [verifyCartSubtotalEqualsGrandTotal] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Click on view and edit cart link");
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
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartToOpen
		$I->conditionalClick("#block-shipping-heading", "#block-shipping-heading", true); // stepKey: clickEstimateShippingAndTaxToOpen
		$I->waitForPageLoad(5); // stepKey: clickEstimateShippingAndTaxToOpenWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEstimateShippingAndTaxToOpen
		$I->selectOption("select[name='country_id']", "US"); // stepKey: selectUnitedStatesCountry
		$I->waitForPageLoad(10); // stepKey: selectUnitedStatesCountryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToSelectCountry
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectCaliforniaRegion
		$I->waitForPageLoad(10); // stepKey: selectCaliforniaRegionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToSelectState
		$I->fillField("input[name='postcode']", "90001"); // stepKey: inputPostCode
		$I->waitForPageLoad(10); // stepKey: inputPostCodeWaitForPageLoad
		$I->comment("After selecting country, province and postcode, verify AssertCartPriceRuleConditionIsApplied and AssertCartPriceRuleFreeShippingIsApplied");
		$I->comment("Entering Action Group [cartAssert] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCartAssert
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCartAssert
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCartAssertWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCartAssert
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCartAssertWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCartAssert
		$I->see("$560.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCartAssert
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCartAssert
		$I->waitForText("$0.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCartAssert
		$I->see("$280.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCartAssert
		$I->comment("Exiting Action Group [cartAssert] StorefrontCheckCartActionGroup");
		$I->see("$0.00", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: seeAssertFreeShippingConditionApplied
		$I->comment("Entering Action Group [seeAssertDiscountAmountAppliedForMatchingItemsConditionIsTrue] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeAssertDiscountAmountAppliedForMatchingItemsConditionIsTrue
		$I->see("-$280.00", "td[data-th='Discount']"); // stepKey: assertDiscountSeeAssertDiscountAmountAppliedForMatchingItemsConditionIsTrue
		$I->comment("Exiting Action Group [seeAssertDiscountAmountAppliedForMatchingItemsConditionIsTrue] AssertStorefrontCartDiscountActionGroup");
	}
}
