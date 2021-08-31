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
 * @Title("MC-38971: Create Cart Price Rule with Subtotal Incl Tax")
 * @Description("Test that cart price rule with Subtotal Incl Tax works correctly<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminCreateCartPriceRuleWithSubtotalInclTaxTest.xml<br>")
 * @TestCaseId("MC-38971")
 * @group SalesRule
 */
class AdminCreateCartPriceRuleWithSubtotalInclTaxTestCest
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
		$I->comment("Login to backend");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create tax rate for US-CA-*");
		$I->createEntity("taxRate", "hook", "defaultTaxRate", [], []); // stepKey: taxRate
		$I->comment("Create tax rule");
		$I->comment("Entering Action Group [createTaxRule] AdminCreateTaxRuleActionGroup");
		$I->comment("Create Tax Rule");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRulePageCreateTaxRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageCreateTaxRule
		$I->click("#add"); // stepKey: addNewTaxRateCreateTaxRule
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateCreateTaxRuleWaitForPageLoad
		$I->fillField("#anchor-content #code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillRuleNameCreateTaxRule
		$I->click("//span[text()='" . $I->retrieveEntityField('taxRate', 'code', 'hook') . "']"); // stepKey: selectTaxRateCreateTaxRule
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettingsCreateTaxRule
		$I->waitForPageLoad(30); // stepKey: clickAdditionalSettingsCreateTaxRuleWaitForPageLoad
		$I->fillField("#priority", "0"); // stepKey: fillPriorityCreateTaxRule
		$I->fillField("#position", "0"); // stepKey: fillPositionCreateTaxRule
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingCreateTaxRule
		$I->click("#save"); // stepKey: clickSaveCreateTaxRule
		$I->waitForPageLoad(90); // stepKey: clickSaveCreateTaxRuleWaitForPageLoad
		$I->comment("Exiting Action Group [createTaxRule] AdminCreateTaxRuleActionGroup");
		$I->comment("Create simple product");
		$productFields['price'] = "100";
		$I->createEntity("product", "hook", "SimpleProduct2", [], $productFields); // stepKey: product
		$I->comment("Create cart price rule with no coupon and 50% discount");
		$I->createEntity("createCartPriceRule", "hook", "ApiCartRule", [], []); // stepKey: createCartPriceRule
		$I->comment("Add \"subtotal incl tax > 100\" condition to cart price rule");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/edit/id/" . $I->retrieveEntityField('createCartPriceRule', 'rule_id', 'hook')); // stepKey: openEditRule
		$I->comment("Entering Action Group [setCartAttributeConditionForCartPriceRule] SetCartAttributeConditionForCartPriceRuleActionGroup");
		$I->scrollTo("div[data-index='conditions']"); // stepKey: scrollToActionTabSetCartAttributeConditionForCartPriceRule
		$I->waitForPageLoad(30); // stepKey: scrollToActionTabSetCartAttributeConditionForCartPriceRuleWaitForPageLoad
		$I->conditionalClick("div[data-index='conditions']", "div[data-index='conditions'] div[data-state-collapsible='open']", false); // stepKey: openActionTabSetCartAttributeConditionForCartPriceRule
		$I->waitForPageLoad(30); // stepKey: openActionTabSetCartAttributeConditionForCartPriceRuleWaitForPageLoad
		$I->click(".rule-param.rule-param-new-child > a"); // stepKey: applyRuleForConditionsSetCartAttributeConditionForCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForDropDownOpenedSetCartAttributeConditionForCartPriceRule
		$I->selectOption("//select[contains(@name, 'new_child')]", "Magento\SalesRule\Model\Rule\Condition\Address|base_subtotal_total_incl_tax"); // stepKey: selectAttributeSetCartAttributeConditionForCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForOperatorOpenedSetCartAttributeConditionForCartPriceRule
		$I->click("//span[@class='rule-param']/a[text()='is']"); // stepKey: clickToChooseOptionSetCartAttributeConditionForCartPriceRule
		$I->selectOption(".rule-param-edit select", "greater than"); // stepKey: setOperatorTypeSetCartAttributeConditionForCartPriceRule
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooseOption1SetCartAttributeConditionForCartPriceRule
		$I->fillField(".rule-param-edit input", "100"); // stepKey: fillActionValueSetCartAttributeConditionForCartPriceRule
		$I->click("button[id*=save_and_continue]"); // stepKey: clickSaveButtonSetCartAttributeConditionForCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSetCartAttributeConditionForCartPriceRuleWaitForPageLoad
		$I->see("You saved the rule.", ".messages"); // stepKey: seeSuccessMessageSetCartAttributeConditionForCartPriceRule
		$I->comment("Exiting Action Group [setCartAttributeConditionForCartPriceRule] SetCartAttributeConditionForCartPriceRuleActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete tax rule");
		$I->comment("Entering Action Group [deleteTaxRule] AdminDeleteTaxRule");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteTaxRule
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteTaxRuleWaitForPageLoad
		$I->fillField("#taxRuleGrid_filter_code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillTaxRuleCodeDeleteTaxRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteTaxRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleSearchDeleteTaxRule
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: clickFirstRowDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickFirstRowDeleteTaxRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteTaxRule
		$I->click("#delete"); // stepKey: clickDeleteRuleDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteRuleDeleteTaxRuleWaitForPageLoad
		$I->click("button.action-primary.action-accept"); // stepKey: clickOkDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickOkDeleteTaxRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteTaxRule] AdminDeleteTaxRule");
		$I->comment("Delete tax rate");
		$I->deleteEntity("taxRate", "hook"); // stepKey: deleteTaxRate
		$I->comment("Delete product");
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->comment("Delete cart price rule");
		$I->deleteEntity("createCartPriceRule", "hook"); // stepKey: deleteCartPriceRule
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
	public function AdminCreateCartPriceRuleWithSubtotalInclTaxTest(AcceptanceTester $I)
	{
		$I->comment("Open product");
		$I->comment("Entering Action Group [openProduct2Page] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProduct2Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProduct2Page
		$I->comment("Exiting Action Group [openProduct2Page] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Add to cart");
		$I->comment("Entering Action Group [product2AddToCart] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadProduct2AddToCart
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonProduct2AddToCart
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonProduct2AddToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartProduct2AddToCart
		$I->waitForPageLoad(60); // stepKey: addToCartProduct2AddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadProduct2AddToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageProduct2AddToCart
		$I->comment("Exiting Action Group [product2AddToCart] StorefrontAddToTheCartActionGroup");
		$I->comment("Click on mini cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
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
		$I->comment("Assert that tax and discount are not applied by default");
		$I->comment("Entering Action Group [AssertTaxAndDiscountIsNotApplied] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlAssertTaxAndDiscountIsNotApplied
		$I->waitForPageLoad(30); // stepKey: waitForCartPageAssertTaxAndDiscountIsNotApplied
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionAssertTaxAndDiscountIsNotApplied
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionAssertTaxAndDiscountIsNotApplied
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionAssertTaxAndDiscountIsNotAppliedWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodAssertTaxAndDiscountIsNotApplied
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodAssertTaxAndDiscountIsNotAppliedWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryAssertTaxAndDiscountIsNotApplied
		$I->see("$100.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertTaxAndDiscountIsNotApplied
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodAssertTaxAndDiscountIsNotApplied
		$I->waitForText("$5.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingAssertTaxAndDiscountIsNotApplied
		$I->see("$105.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertTaxAndDiscountIsNotApplied
		$I->comment("Exiting Action Group [AssertTaxAndDiscountIsNotApplied] StorefrontCheckCartActionGroup");
		$I->dontSee("td[data-th='Discount']"); // stepKey: assertDiscountIsNotApplied
		$I->comment("Open \"Estimate Shipping and Tax\" section and fill US-CA address");
		$I->comment("Entering Action Group [fillEstimateShippingAndTaxSection] StorefrontCartEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: clickOnEstimateShippingAndTaxFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: clickOnEstimateShippingAndTaxFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForCountrySelectorIsVisibleFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: waitForCountrySelectorIsVisibleFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountryFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: selectCountryFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCountryLoadingMaskDisappearFillEstimateShippingAndTaxSection
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectStateProvinceFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: selectStateProvinceFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForStateLoadingMaskDisappearFillEstimateShippingAndTaxSection
		$I->fillField("input[name='postcode']", "90240"); // stepKey: fillZipPostalCodeFieldFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: fillZipPostalCodeFieldFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForZipLoadingMaskDisappearFillEstimateShippingAndTaxSection
		$I->comment("Exiting Action Group [fillEstimateShippingAndTaxSection] StorefrontCartEstimateShippingAndTaxActionGroup");
		$I->comment("Assert that tax and discount are applied by to total amount");
		$I->comment("Entering Action Group [AssertTaxAndDiscountIsApplied] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlAssertTaxAndDiscountIsApplied
		$I->waitForPageLoad(30); // stepKey: waitForCartPageAssertTaxAndDiscountIsApplied
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionAssertTaxAndDiscountIsApplied
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionAssertTaxAndDiscountIsApplied
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionAssertTaxAndDiscountIsAppliedWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodAssertTaxAndDiscountIsApplied
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodAssertTaxAndDiscountIsAppliedWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryAssertTaxAndDiscountIsApplied
		$I->see("$100.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertTaxAndDiscountIsApplied
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodAssertTaxAndDiscountIsApplied
		$I->waitForText("$5.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingAssertTaxAndDiscountIsApplied
		$I->see("$60.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertTaxAndDiscountIsApplied
		$I->comment("Exiting Action Group [AssertTaxAndDiscountIsApplied] StorefrontCheckCartActionGroup");
		$I->see("-$50.00", "td[data-th='Discount']"); // stepKey: assertDiscountIsApplied
	}
}
