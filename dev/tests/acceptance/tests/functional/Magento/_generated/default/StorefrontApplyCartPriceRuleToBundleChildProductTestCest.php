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
 * @Title("MC-36654: Checking Cart Price Rule for bundle products")
 * @Description("Checking Cart Price Rule for bundle products<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontApplyCartPriceRuleToBundleChildProductTest.xml<br>")
 * @TestCaseId("MC-36654")
 * @group salesRule
 */
class StorefrontApplyCartPriceRuleToBundleChildProductTestCest
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
		$createSimpleProduct1Fields['price'] = "5.00";
		$I->createEntity("createSimpleProduct1", "hook", "SimpleProduct2", [], $createSimpleProduct1Fields); // stepKey: createSimpleProduct1
		$createSimpleProduct2Fields['price'] = "3.00";
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct2", [], $createSimpleProduct2Fields); // stepKey: createSimpleProduct2
		$createSimpleProduct3Fields['price'] = "7.00";
		$I->createEntity("createSimpleProduct3", "hook", "SimpleProduct2", [], $createSimpleProduct3Fields); // stepKey: createSimpleProduct3
		$createSimpleProduct4Fields['price'] = "18.00";
		$I->createEntity("createSimpleProduct4", "hook", "SimpleProduct2", [], $createSimpleProduct4Fields); // stepKey: createSimpleProduct4
		$I->createEntity("createBundleProduct", "hook", "ApiBundleProduct", [], []); // stepKey: createBundleProduct
		$I->createEntity("createDropDownBundleOption", "hook", "DropDownBundleOption", ["createBundleProduct"], []); // stepKey: createDropDownBundleOption
		$I->createEntity("createCheckboxBundleOption", "hook", "CheckboxOption", ["createBundleProduct"], []); // stepKey: createCheckboxBundleOption
		$I->createEntity("linkDropDownOptionToProduct1", "hook", "ApiBundleLink", ["createBundleProduct", "createDropDownBundleOption", "createSimpleProduct1"], []); // stepKey: linkDropDownOptionToProduct1
		$I->createEntity("linkDropDownOptionToProduct2", "hook", "ApiBundleLink", ["createBundleProduct", "createDropDownBundleOption", "createSimpleProduct2"], []); // stepKey: linkDropDownOptionToProduct2
		$I->createEntity("linkCheckboxOptionToProduct3", "hook", "ApiBundleLink", ["createBundleProduct", "createCheckboxBundleOption", "createSimpleProduct3"], []); // stepKey: linkCheckboxOptionToProduct3
		$I->createEntity("linkCheckboxOptionToProduct4", "hook", "ApiBundleLink", ["createBundleProduct", "createCheckboxBundleOption", "createSimpleProduct4"], []); // stepKey: linkCheckboxOptionToProduct4
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Make Attribute 'sku' accessible for Promo Rule Conditions");
		$I->comment("Entering Action Group [editSkuAttribute] NavigateToEditProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridEditSkuAttribute
		$I->fillField("#attributeGrid_filter_frontend_label", "sku"); // stepKey: navigateToAttributeEditPage1EditSkuAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: navigateToAttributeEditPage2EditSkuAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage2EditSkuAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2EditSkuAttribute
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: navigateToAttributeEditPage3EditSkuAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage3EditSkuAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3EditSkuAttribute
		$I->comment("Exiting Action Group [editSkuAttribute] NavigateToEditProductAttributeActionGroup");
		$I->comment("Entering Action Group [changeAttributePromoRule] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStoreFrontPropertiesTabChangeAttributePromoRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadChangeAttributePromoRule
		$I->selectOption("#is_used_for_promo_rules", "1"); // stepKey: changeOptionChangeAttributePromoRule
		$I->click("#save"); // stepKey: saveAttributeChangeAttributePromoRule
		$I->waitForPageLoad(30); // stepKey: saveAttributeChangeAttributePromoRuleWaitForPageLoad
		$I->see("You saved the product attribute.", "#messages div.message-success"); // stepKey: successMessageChangeAttributePromoRule
		$I->comment("Exiting Action Group [changeAttributePromoRule] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$I->comment("Entering Action Group [deleteCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: goToAdminCartPriceRuleGridPageDeleteCartPriceRules
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteCartPriceRules
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteCartPriceRules
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteCartPriceRulesWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteCartPriceRules] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteCartPriceRules
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteCartPriceRules
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteCartPriceRules
		$I->comment("Exiting Action Group [deleteCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
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
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createSimpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("createSimpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->comment("Entering Action Group [deleteCartPriceRule] AdminDeleteCartPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: goToCartPriceRulesDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForCartPriceRulesDeleteCartPriceRule
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFilterBeforeDeleteDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: resetFilterBeforeDeleteDeleteCartPriceRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCartPriceRulesResetFilterDeleteCartPriceRule
		$I->fillField("input[name='name']", "CartPriceRule" . msq("CatPriceRule")); // stepKey: filterByNameDeleteCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteCartPriceRule
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteCartPriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteCartPriceRule
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCartPriceRule] AdminDeleteCartPriceRuleActionGroup");
		$I->comment("Revert Attribute 'sku' to it's default value (not accessible for Promo Rule Conditions)");
		$I->comment("Entering Action Group [editSkuAttribute] NavigateToEditProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridEditSkuAttribute
		$I->fillField("#attributeGrid_filter_frontend_label", "sku"); // stepKey: navigateToAttributeEditPage1EditSkuAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: navigateToAttributeEditPage2EditSkuAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage2EditSkuAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2EditSkuAttribute
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: navigateToAttributeEditPage3EditSkuAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage3EditSkuAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3EditSkuAttribute
		$I->comment("Exiting Action Group [editSkuAttribute] NavigateToEditProductAttributeActionGroup");
		$I->comment("Entering Action Group [changeAttributePromoRule] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStoreFrontPropertiesTabChangeAttributePromoRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadChangeAttributePromoRule
		$I->selectOption("#is_used_for_promo_rules", "0"); // stepKey: changeOptionChangeAttributePromoRule
		$I->click("#save"); // stepKey: saveAttributeChangeAttributePromoRule
		$I->waitForPageLoad(30); // stepKey: saveAttributeChangeAttributePromoRuleWaitForPageLoad
		$I->see("You saved the product attribute.", "#messages div.message-success"); // stepKey: successMessageChangeAttributePromoRule
		$I->comment("Exiting Action Group [changeAttributePromoRule] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"SalesRule"})
	 * @Stories({"Create cart price rule"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontApplyCartPriceRuleToBundleChildProductTest(AcceptanceTester $I)
	{
		$I->comment("Start to create new cart price rule via SKU conditions and not default condition value");
		$I->comment("Entering Action Group [createRule] AdminCreateCartPriceRuleWithConditionAndNotDefaultConditionOperatorActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateRule
		$I->click("#add"); // stepKey: clickAddNewRuleCreateRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateRuleWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateRule
		$I->fillField("input[name='name']", "CartPriceRule" . msq("CatPriceRule")); // stepKey: fillRuleNameCreateRule
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateRule
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN',  'General',  'Wholesale',  'Retailer']); // stepKey: selectCustomerGroupCreateRule
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateRule
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateRuleWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateRule
		$I->fillField("input[name='discount_amount']", "10"); // stepKey: fillDiscountAmountCreateRule
		$I->click("div[data-index='actions']"); // stepKey: clickOnActionTabCreateRule
		$I->waitForPageLoad(30); // stepKey: clickOnActionTabCreateRuleWaitForPageLoad
		$I->click(".rule-param.rule-param-new-child > a"); // stepKey: clickConditionDropDownMenuCreateRule
		$I->selectOption("//select[contains(@name, 'new_child')]", "SKU"); // stepKey: selectConditionAttributeCreateRule
		$I->waitForPageLoad(30); // stepKey: waitForOperatorOpenedCreateRule
		$I->click("//span[@class='rule-param']/a[text()='is']"); // stepKey: clickToChooseConditionCreateRule
		$I->selectOption("//select[contains(@name, '[operator]')]", "is one of"); // stepKey: selectOperatorCreateRule
		$I->waitForPageLoad(30); // stepKey: waitForOperatorOpened1CreateRule
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooserIconCreateRule
		$I->fillField(".rule-param-edit input", $I->retrieveEntityField('createSimpleProduct1', 'sku', 'test') . ", " . $I->retrieveEntityField('createSimpleProduct2', 'sku', 'test')); // stepKey: choseNeededCategoryFromCategoryGridCreateRule
		$I->click(".rule-param-apply"); // stepKey: applyActionCreateRule
		$I->waitForPageLoad(30); // stepKey: applyActionCreateRuleWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonCreateRule
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateRule
		$I->waitForPageLoad(30); // stepKey: waitForDropDownOpenedCreateRule
		$I->comment("Exiting Action Group [createRule] AdminCreateCartPriceRuleWithConditionAndNotDefaultConditionOperatorActionGroup");
		$I->comment("Add Bundle product with simple1 and simple3 products to the cart");
		$I->comment("Entering Action Group [openProductStorefront] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefront
		$I->comment("Exiting Action Group [openProductStorefront] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeAndAddToCart
		$I->comment("Exiting Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [addSimpleProduct1] StorefrontSelectBundleProductDropDownOptionActionGroup");
		$I->click("//div[@class='control']/select"); // stepKey: clickOnSelectOptionAddSimpleProduct1
		$I->click("//div[@class='control']/select/option[contains(.,'" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: selectProductAddSimpleProduct1
		$I->comment("Exiting Action Group [addSimpleProduct1] StorefrontSelectBundleProductDropDownOptionActionGroup");
		$I->checkOption("//label//span[contains(text(), 'bundle-option-checkbox" . msq("CheckboxOption") . "')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: selectFirstCheckboxOption
		$I->comment("Entering Action Group [addToTheCartBundleProduct] StorefrontAddToTheCartButtonActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToTheCartBundleProduct
		$I->waitForElementVisible("#product-addtocart-button", 30); // stepKey: waitForAddToCartButtonAddToTheCartBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartButtonAddToTheCartBundleProductWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddToTheCartBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartButtonAddToTheCartBundleProductWaitForPageLoad
		$I->comment("Exiting Action Group [addToTheCartBundleProduct] StorefrontAddToTheCartButtonActionGroup");
		$I->see("You added " . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessage
		$I->comment("Click \"mini cart\" icon");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForDetailsOpen
		$I->comment("Check all products and Cart Subtotal and Discount is only for SimpleProduct1");
		$I->comment("Entering Action Group [checkDiscountIsAppliedOnlyForSimple1productOnly] StorefrontCheckCartTotalWithDiscountCategoryActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCheckDiscountIsAppliedOnlyForSimple1productOnlyWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCheckDiscountIsAppliedOnlyForSimple1productOnlyWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->see("12.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->waitForText("5.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->see("16.50", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->see("-$0.50", "td[data-th='Discount']"); // stepKey: assertDiscountCheckDiscountIsAppliedOnlyForSimple1productOnly
		$I->comment("Exiting Action Group [checkDiscountIsAppliedOnlyForSimple1productOnly] StorefrontCheckCartTotalWithDiscountCategoryActionGroup");
		$I->comment("Clear Shopping cart");
		$I->comment("Entering Action Group [clearShoppingCart] DeleteProductFromShoppingCartActionGroup");
		$I->click("//*[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/ancestor::tbody//a[@class='action action-delete']"); // stepKey: deleteProductFromCheckoutCartClearShoppingCart
		$I->waitForPageLoad(30); // stepKey: deleteProductFromCheckoutCartClearShoppingCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearShoppingCart
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartClearShoppingCart
		$I->comment("Exiting Action Group [clearShoppingCart] DeleteProductFromShoppingCartActionGroup");
		$I->comment("Add Bundle product with simple2 and simple3 products to the cart");
		$I->comment("Entering Action Group [openProductStorefront2] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductStorefront2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefront2
		$I->comment("Exiting Action Group [openProductStorefront2] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [clickCustomizeAndAddToCart2] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCart2
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCart2WaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCart2
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeAndAddToCart2
		$I->comment("Exiting Action Group [clickCustomizeAndAddToCart2] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [addSimpleProduct2] StorefrontSelectBundleProductDropDownOptionActionGroup");
		$I->click("//div[@class='control']/select"); // stepKey: clickOnSelectOptionAddSimpleProduct2
		$I->click("//div[@class='control']/select/option[contains(.,'" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: selectProductAddSimpleProduct2
		$I->comment("Exiting Action Group [addSimpleProduct2] StorefrontSelectBundleProductDropDownOptionActionGroup");
		$I->checkOption("//label//span[contains(text(), 'bundle-option-checkbox" . msq("CheckboxOption") . "')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: selectFirstCheckboxOption2
		$I->comment("Entering Action Group [addToTheCartBundleProduct2] StorefrontAddToTheCartButtonActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToTheCartBundleProduct2
		$I->waitForElementVisible("#product-addtocart-button", 30); // stepKey: waitForAddToCartButtonAddToTheCartBundleProduct2
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartButtonAddToTheCartBundleProduct2WaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddToTheCartBundleProduct2
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartButtonAddToTheCartBundleProduct2WaitForPageLoad
		$I->comment("Exiting Action Group [addToTheCartBundleProduct2] StorefrontAddToTheCartButtonActionGroup");
		$I->comment("Click \"mini cart\" icon");
		$I->comment("Entering Action Group [openCart2] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart2
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart2
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCart2WaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart2
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCart2WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart2
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCart2WaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart2
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCart2WaitForPageLoad
		$I->comment("Exiting Action Group [openCart2] StorefrontOpenCartFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForDetailsOpen2
		$I->comment("Check all products and Cart Subtotal and Discount is only for SimpleProduct2");
		$I->comment("Entering Action Group [checkDiscountIsAppliedOnlyForSimple2productOnly] StorefrontCheckCartTotalWithDiscountCategoryActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCheckDiscountIsAppliedOnlyForSimple2productOnlyWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCheckDiscountIsAppliedOnlyForSimple2productOnlyWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->see("10.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->waitForText("5.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->see("14.70", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->see("-$0.30", "td[data-th='Discount']"); // stepKey: assertDiscountCheckDiscountIsAppliedOnlyForSimple2productOnly
		$I->comment("Exiting Action Group [checkDiscountIsAppliedOnlyForSimple2productOnly] StorefrontCheckCartTotalWithDiscountCategoryActionGroup");
	}
}
