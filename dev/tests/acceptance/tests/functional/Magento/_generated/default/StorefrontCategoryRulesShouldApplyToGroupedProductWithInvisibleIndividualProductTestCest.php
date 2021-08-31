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
 * @Title("MC-31863: Category rules should apply to grouped product with invisible individual products")
 * @Description("Category rules should apply to grouped product with invisible individual products<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontCategoryRulesShouldApplyToGroupedProductWithInvisibleIndividualProductTest.xml<br>")
 * @TestCaseId("MC-31863")
 * @group SalesRule
 */
class StorefrontCategoryRulesShouldApplyToGroupedProductWithInvisibleIndividualProductTestCest
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
		$I->createEntity("createCategoryOne", "hook", "ApiCategory", [], []); // stepKey: createCategoryOne
		$createFirstSimpleProductFields['price'] = "100";
		$createFirstSimpleProductFields['visibility'] = "1";
		$I->createEntity("createFirstSimpleProduct", "hook", "ApiSimpleProduct", ["createCategoryOne"], $createFirstSimpleProductFields); // stepKey: createFirstSimpleProduct
		$createSecondSimpleProductFields['price'] = "200";
		$createSecondSimpleProductFields['visibility'] = "1";
		$I->createEntity("createSecondSimpleProduct", "hook", "ApiSimpleProduct", ["createCategoryOne"], $createSecondSimpleProductFields); // stepKey: createSecondSimpleProduct
		$I->createEntity("createCategoryTwo", "hook", "ApiCategory", [], []); // stepKey: createCategoryTwo
		$createThirdSimpleProductFields['price'] = "300";
		$createThirdSimpleProductFields['visibility'] = "1";
		$I->createEntity("createThirdSimpleProduct", "hook", "ApiSimpleProduct", ["createCategoryTwo"], $createThirdSimpleProductFields); // stepKey: createThirdSimpleProduct
		$createFourthSimpleProductFields['price'] = "400";
		$createFourthSimpleProductFields['visibility'] = "1";
		$I->createEntity("createFourthSimpleProduct", "hook", "ApiSimpleProduct", ["createCategoryTwo"], $createFourthSimpleProductFields); // stepKey: createFourthSimpleProduct
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct2", ["createCategoryOne"], []); // stepKey: createGroupedProduct
		$I->createEntity("addFirstProduct", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createFirstSimpleProduct"], []); // stepKey: addFirstProduct
		$I->updateEntity("addFirstProduct", "hook", "OneMoreSimpleProductLink",["createGroupedProduct", "createSecondSimpleProduct"]); // stepKey: addSecondProduct
		$I->createEntity("createSecondGroupedProduct", "hook", "ApiGroupedProduct2", ["createCategoryTwo"], []); // stepKey: createSecondGroupedProduct
		$I->createEntity("addThirdProduct", "hook", "OneSimpleProductLink", ["createSecondGroupedProduct", "createThirdSimpleProduct"], []); // stepKey: addThirdProduct
		$I->updateEntity("addThirdProduct", "hook", "OneMoreSimpleProductLink",["createSecondGroupedProduct", "createFourthSimpleProduct"]); // stepKey: addFourthProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createThirdSimpleProduct", "hook"); // stepKey: deleteThirdSimpleProduct
		$I->deleteEntity("createFourthSimpleProduct", "hook"); // stepKey: deleteFourthSimpleProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
		$I->deleteEntity("createSecondGroupedProduct", "hook"); // stepKey: deleteSecondGroupedProduct
		$I->deleteEntity("createCategoryOne", "hook"); // stepKey: deleteCategoryOne
		$I->deleteEntity("createCategoryTwo", "hook"); // stepKey: deleteCategoryTwo
		$I->comment("Entering Action Group [deleteCartPriceRule] AdminDeleteCartPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: goToCartPriceRulesDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForCartPriceRulesDeleteCartPriceRule
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFilterBeforeDeleteDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: resetFilterBeforeDeleteDeleteCartPriceRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCartPriceRulesResetFilterDeleteCartPriceRule
		$I->fillField("input[name='name']", "TestSalesRule" . msq("TestSalesRule")); // stepKey: filterByNameDeleteCartPriceRule
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
		$I->comment("Entering Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"SalesRule"})
	 * @Stories({"Create cart price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCategoryRulesShouldApplyToGroupedProductWithInvisibleIndividualProductTest(AcceptanceTester $I)
	{
		$I->comment("Start to create new cart price rule via Category conditions");
		$I->comment("Entering Action Group [createCartPriceRuleWithCondition] AdminCreateCartPriceRuleWithConditionIsCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateCartPriceRuleWithCondition
		$I->click("#add"); // stepKey: clickAddNewRuleCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateCartPriceRuleWithConditionWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateCartPriceRuleWithCondition
		$I->fillField("input[name='name']", "TestSalesRule" . msq("TestSalesRule")); // stepKey: fillRuleNameCreateCartPriceRuleWithCondition
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateCartPriceRuleWithCondition
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN',  'General',  'Wholesale',  'Retailer']); // stepKey: selectCustomerGroupCreateCartPriceRuleWithCondition
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateCartPriceRuleWithConditionWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateCartPriceRuleWithCondition
		$I->fillField("input[name='discount_amount']", "50"); // stepKey: fillDiscountAmountCreateCartPriceRuleWithCondition
		$I->click("div[data-index='actions']"); // stepKey: clickOnActionTabCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: clickOnActionTabCreateCartPriceRuleWithConditionWaitForPageLoad
		$I->click("//span[@class='rule-param']/a[text()='ALL']"); // stepKey: clickToChooseFirstRuleConditionValueCreateCartPriceRuleWithCondition
		$I->selectOption("#actions__1__aggregator", "ANY"); // stepKey: changeFirstRuleConditionValueCreateCartPriceRuleWithCondition
		$I->click("//span[@class='rule-param']/a[text()='TRUE']"); // stepKey: clickToChooseSecondRuleConditionValueCreateCartPriceRuleWithCondition
		$I->selectOption("#actions__1__value", "FALSE"); // stepKey: changeSecondRuleConditionValueCreateCartPriceRuleWithCondition
		$I->click(".rule-param.rule-param-new-child > a"); // stepKey: clickConditionDropDownMenuCreateCartPriceRuleWithCondition
		$I->selectOption("//select[contains(@name, 'new_child')]", "Category"); // stepKey: selectConditionAttributeIsCategoryCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: waitForOperatorOpenedCreateCartPriceRuleWithCondition
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooserIconCreateCartPriceRuleWithCondition
		$I->fillField(".rule-param-edit input", $I->retrieveEntityField('createCategoryTwo', 'id', 'test')); // stepKey: choseNeededCategoryFromCategoryGridCreateCartPriceRuleWithCondition
		$I->click(".rule-param-apply"); // stepKey: applyActionCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: applyActionCreateCartPriceRuleWithConditionWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateCartPriceRuleWithConditionWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateCartPriceRuleWithCondition
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateCartPriceRuleWithCondition
		$I->waitForPageLoad(30); // stepKey: waitForDropDownOpenedCreateCartPriceRuleWithCondition
		$I->comment("Exiting Action Group [createCartPriceRuleWithCondition] AdminCreateCartPriceRuleWithConditionIsCategoryActionGroup");
		$I->comment("Add SecondGroupedProduct to the cart");
		$I->comment("Entering Action Group [addSecondGroupedProductToCart] StorefrontAddGroupedProductWithTwoLinksToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSecondGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSecondGroupedProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSecondGroupedProductToCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('createThirdSimpleProduct', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForFirsProductAddSecondGroupedProductToCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('createFourthSimpleProduct', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForSecondProductAddSecondGroupedProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSecondGroupedProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSecondGroupedProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSecondGroupedProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSecondGroupedProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSecondGroupedProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondGroupedProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSecondGroupedProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSecondGroupedProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondGroupedProductToCart
		$I->comment("Exiting Action Group [addSecondGroupedProductToCart] StorefrontAddGroupedProductWithTwoLinksToCartActionGroup");
		$I->comment("Entering Action Group [openTheCartWithSecondGroupedProduct] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartOpenTheCartWithSecondGroupedProduct
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartOpenTheCartWithSecondGroupedProductWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartOpenTheCartWithSecondGroupedProduct
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleOpenTheCartWithSecondGroupedProduct
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleOpenTheCartWithSecondGroupedProductWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartOpenTheCartWithSecondGroupedProduct
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartOpenTheCartWithSecondGroupedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenTheCartWithSecondGroupedProduct
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlOpenTheCartWithSecondGroupedProduct
		$I->comment("Exiting Action Group [openTheCartWithSecondGroupedProduct] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Discount  amount is not applied");
		$I->comment("Entering Action Group [checkDiscountIsNotApplied] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCheckDiscountIsNotApplied
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCheckDiscountIsNotApplied
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCheckDiscountIsNotApplied
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCheckDiscountIsNotApplied
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCheckDiscountIsNotAppliedWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCheckDiscountIsNotApplied
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCheckDiscountIsNotAppliedWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCheckDiscountIsNotApplied
		$I->see("$700.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCheckDiscountIsNotApplied
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCheckDiscountIsNotApplied
		$I->waitForText("$10.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCheckDiscountIsNotApplied
		$I->see("$710.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCheckDiscountIsNotApplied
		$I->comment("Exiting Action Group [checkDiscountIsNotApplied] StorefrontCheckCartActionGroup");
		$I->comment("Discount is absent in cart subtotal");
		$I->dontSeeElement("//*[@id='cart-totals']//tr[.//th//span[contains(@class, 'discount coupon')]]"); // stepKey: discountIsNotApplied
		$I->comment("Add FirstGroupedProduct to the cart");
		$I->comment("Entering Action Group [addFirsGroupedProductToCart] StorefrontAddGroupedProductWithTwoLinksToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddFirsGroupedProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddFirsGroupedProductToCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForFirsProductAddFirsGroupedProductToCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('createSecondSimpleProduct', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForSecondProductAddFirsGroupedProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddFirsGroupedProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddFirsGroupedProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirsGroupedProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirsGroupedProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddFirsGroupedProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirsGroupedProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddFirsGroupedProductToCart
		$I->see("You added " . $I->retrieveEntityField('createGroupedProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirsGroupedProductToCart
		$I->comment("Exiting Action Group [addFirsGroupedProductToCart] StorefrontAddGroupedProductWithTwoLinksToCartActionGroup");
		$I->comment("Entering Action Group [openTheCartWithFirstAndSecondGroupedProducts] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartOpenTheCartWithFirstAndSecondGroupedProducts
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartOpenTheCartWithFirstAndSecondGroupedProductsWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartOpenTheCartWithFirstAndSecondGroupedProducts
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleOpenTheCartWithFirstAndSecondGroupedProducts
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleOpenTheCartWithFirstAndSecondGroupedProductsWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartOpenTheCartWithFirstAndSecondGroupedProducts
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartOpenTheCartWithFirstAndSecondGroupedProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenTheCartWithFirstAndSecondGroupedProducts
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlOpenTheCartWithFirstAndSecondGroupedProducts
		$I->comment("Exiting Action Group [openTheCartWithFirstAndSecondGroupedProducts] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Discount amount is applied for product from first category only");
		$I->comment("Entering Action Group [checkDiscountIsApplied] StorefrontCheckCartTotalWithDiscountCategoryActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCheckDiscountIsApplied
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCheckDiscountIsApplied
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCheckDiscountIsApplied
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCheckDiscountIsApplied
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCheckDiscountIsAppliedWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCheckDiscountIsApplied
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCheckDiscountIsAppliedWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCheckDiscountIsApplied
		$I->see("$1,000.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCheckDiscountIsApplied
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCheckDiscountIsApplied
		$I->waitForText("$20.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCheckDiscountIsApplied
		$I->see("$870.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCheckDiscountIsApplied
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountCheckDiscountIsApplied
		$I->see("-$150.00", "td[data-th='Discount']"); // stepKey: assertDiscountCheckDiscountIsApplied
		$I->comment("Exiting Action Group [checkDiscountIsApplied] StorefrontCheckCartTotalWithDiscountCategoryActionGroup");
	}
}
