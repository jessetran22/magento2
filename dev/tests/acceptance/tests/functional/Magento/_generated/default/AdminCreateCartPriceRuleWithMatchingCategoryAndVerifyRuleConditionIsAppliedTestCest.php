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
 * @Title("MC-15608: Create Cart Price Rule With Matching Category And Verify Rule Condition Is Applied")
 * @Description("Test log in to Cart Price Rules and Create Cart Price Rule With Matching Category And Verify Rule Condition Is Applied<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminCreateCartPriceRuleWithMatchingCategoryAndVerifyRuleConditionIsAppliedTest.xml<br>")
 * @TestCaseId("MC-15608")
 * @group SalesRule
 * @group mtf_migrated
 */
class AdminCreateCartPriceRuleWithMatchingCategoryAndVerifyRuleConditionIsAppliedTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Entering Action Group [fillProductFieldsInAdmin] FillAdminSimpleProductFormActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFillProductFieldsInAdmin
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownFillProductFieldsInAdminWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddSimpleProductFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: clickAddSimpleProductFillProductFieldsInAdminWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityFillProductFieldsInAdmin
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityFillProductFieldsInAdmin
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'hook')]); // stepKey: searchAndSelectCategoryFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryFillProductFieldsInAdminWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: openSeoSectionFillProductFieldsInAdminWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyFillProductFieldsInAdmin
		$I->click("#save-button"); // stepKey: saveProductFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: saveProductFillProductFieldsInAdminWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: assertFieldNameFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: assertFieldSkuFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=price] input", "123.00"); // stepKey: assertFieldPriceFillProductFieldsInAdmin
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionAssertFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: openSeoSectionAssertFillProductFieldsInAdminWaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: assertFieldUrlKeyFillProductFieldsInAdmin
		$I->comment("Exiting Action Group [fillProductFieldsInAdmin] FillAdminSimpleProductFormActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deletePreReqCategory
		$I->comment("Entering Action Group [deleteSimpleProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteSimpleProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteSimpleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteSimpleProduct
		$I->fillField("input.admin__control-text[name='name']", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFilterDeleteSimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSimpleProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSimpleProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSimpleProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSimpleProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSimpleProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSimpleProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteSimpleProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteSimpleProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSimpleProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteCreatedCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteCreatedCartPriceRule
		$I->fillField("input[name='name']", "Cart Price Rule With Category Condition Applied" . msq("CartPriceRuleConditionAppliedForCategory")); // stepKey: filterByNameDeleteCreatedCartPriceRule
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
	public function AdminCreateCartPriceRuleWithMatchingCategoryAndVerifyRuleConditionIsAppliedTest(AcceptanceTester $I)
	{
		$I->comment("Create cart price rule as per data and verify AssertCartPriceRuleSuccessSaveMessage");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->fillField("input[name='name']", "Cart Price Rule With Category Condition Applied" . msq("CartPriceRuleConditionAppliedForCategory")); // stepKey: fillRuleName
		$I->fillField("//div[@class='admin__field-control']/textarea[@name='description']", "Description for Cart Price Rule"); // stepKey: fillDescription
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsites
		$I->selectOption("select[name='customer_group_ids']", ["NOT LOGGED IN"]); // stepKey: selectCustomerGroup
		$I->selectOption("select[name='coupon_type']", "No Coupon"); // stepKey: selectCouponType
		$I->scrollTo("div[data-index='conditions']"); // stepKey: scrollToConditionsHeader
		$I->waitForPageLoad(30); // stepKey: scrollToConditionsHeaderWaitForPageLoad
		$I->conditionalClick("div[data-index='conditions']", "div[data-index='conditions']", true); // stepKey: clickToExpandConditions
		$I->waitForPageLoad(30); // stepKey: clickToExpandConditionsWaitForPageLoad
		$I->click("//ul[@id = 'conditions__1__children']/li/span[contains(@class, 'rule-param-new-child')]"); // stepKey: clickOnAddNewCondition
		$I->waitForPageLoad(30); // stepKey: clickOnAddNewConditionWaitForPageLoad
		$I->selectOption("select[name='rule[conditions][1][new_child]']", "Product attribute combination"); // stepKey: selectProductAttributeCombination
		$I->waitForPageLoad(30); // stepKey: waitForConditionLoad
		$I->click("//ul[@id = 'conditions__1--1__children']/li/span[contains(@class, 'rule-param-new-child')]"); // stepKey: clickOnTheAddNewCondition
		$I->waitForPageLoad(30); // stepKey: clickOnTheAddNewConditionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForToggleLoad
		$I->selectOption("select[name='rule[conditions][1--1][new_child]']", "Category"); // stepKey: selectCategory
		$I->waitForElementVisible("//ul[contains(@id, 'conditions')]//a[.='...']", 30); // stepKey: waitForEllipsis
		$I->click("//ul[contains(@id, 'conditions')]//a[.='...']"); // stepKey: clickOnEllipsis
		$I->fillField("[id='conditions__1--1--1__value']", $I->retrieveEntityField('createCategory', 'id', 'test')); // stepKey: fillTotalItemQuantity
		$I->comment("Entering Action Group [createActiveCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->conditionalClick("div[data-index='actions']", "div[data-index='actions']", true); // stepKey: clickToExpandActionsCreateActiveCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateActiveCartPriceRuleActionsSectionWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_amount']", "50"); // stepKey: fillDiscountAmountCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_qty']", "0"); // stepKey: fillMaximumQtyDiscountCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_step']", "0"); // stepKey: fillDiscountStepCreateActiveCartPriceRuleActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->comment("Entering Action Group [createActiveCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->selectOption("//select[@name='simple_free_shipping']", "No"); // stepKey: selectForMatchingItemsOnlyCreateActiveCartPriceRuleFreeShippingActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->scrollTo("div[data-index='labels']"); // stepKey: scrollToLabelsHeader
		$I->waitForPageLoad(30); // stepKey: scrollToLabelsHeaderWaitForPageLoad
		$I->comment("Entering Action Group [createActiveCartPriceRuleLabelsSection] AdminCreateCartPriceRuleLabelsSectionActionGroup");
		$I->conditionalClick("div[data-index='labels']", "div[data-index='labels']", true); // stepKey: clickToExpandLabelsCreateActiveCartPriceRuleLabelsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandLabelsCreateActiveCartPriceRuleLabelsSectionWaitForPageLoad
		$I->fillField("input[name='store_labels[0]']", "Product attribute combination - Category"); // stepKey: fillDefaultRuleLabelAllStoreViewsCreateActiveCartPriceRuleLabelsSection
		$I->fillField("input[name='store_labels[1]']", "Product attribute combination - Category"); // stepKey: fillDefaultStoreViewCreateActiveCartPriceRuleLabelsSection
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
		$I->fillField("input[name='name']", "Cart Price Rule With Category Condition Applied" . msq("CartPriceRuleConditionAppliedForCategory")); // stepKey: filterByNameSearchCreatedCartPriceRuleInGrid
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterSearchCreatedCartPriceRuleInGrid
		$I->waitForPageLoad(30); // stepKey: doFilterSearchCreatedCartPriceRuleInGridWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageSearchCreatedCartPriceRuleInGrid
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageSearchCreatedCartPriceRuleInGridWaitForPageLoad
		$I->comment("Exiting Action Group [searchCreatedCartPriceRuleInGrid] AdminFilterCartPriceRuleActionGroup");
		$I->comment("Go to cart price rule form page and verify AssertCartPriceRuleForm");
		$I->waitForPageLoad(30); // stepKey: waitForAdminCartPriceRuleEditPageLoad
		$I->seeInField("input[name='name']", "Cart Price Rule With Category Condition Applied" . msq("CartPriceRuleConditionAppliedForCategory")); // stepKey: seeRuleName
		$I->seeInField("//div[@class='admin__field-control']/textarea[@name='description']", "Description for Cart Price Rule"); // stepKey: seeDescription
		$I->seeInField("select[name='website_ids']", "Main Website"); // stepKey: seeWebsites
		$I->seeInField("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: seeCustomerGroup
		$I->seeInField("select[name='coupon_type']", "No Coupon"); // stepKey: seeCouponType
		$I->conditionalClick("div[data-index='conditions']", "div[data-index='conditions']", true); // stepKey: clickToExpandConditionHeader
		$I->waitForPageLoad(30); // stepKey: clickToExpandConditionHeaderWaitForPageLoad
		$I->seeInField("[id='conditions__1--1--1__value']", $I->retrieveEntityField('createCategory', 'id', 'test')); // stepKey: seeCategoryParameter
		$I->conditionalClick("div[data-index='actions']", "div[data-index='actions']", true); // stepKey: clickExpandActions
		$I->waitForPageLoad(30); // stepKey: clickExpandActionsWaitForPageLoad
		$I->see("Percent of product price discount", "select[name='simple_action']"); // stepKey: seeActionApplyType
		$I->seeInField("input[name='discount_amount']", "50"); // stepKey: seeDiscountAmount
		$I->seeInField("//select[@name='simple_free_shipping']", "No"); // stepKey: seeFreeShipping
		$I->conditionalClick("div[data-index='labels']", "div[data-index='labels']", true); // stepKey: clickToExpandLabels
		$I->waitForPageLoad(30); // stepKey: clickToExpandLabelsWaitForPageLoad
		$I->seeInField("input[name='store_labels[0]']", "Product attribute combination - Category"); // stepKey: seeDefaultRuleLabelAllStoreViews
		$I->seeInField("input[name='store_labels[1]']", "Product attribute combination - Category"); // stepKey: seeDefaultStoreView
		$I->comment("Go to storefront page and verify created product");
		$I->amOnPage("/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(60); // stepKey: addToCartOpenProductPageAndVerifyProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartOpenProductPageAndVerifyProduct
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingOpenProductPageAndVerifyProduct
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenProductPageAndVerifyProduct
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageOpenProductPageAndVerifyProduct
		$I->see("You added testProductName" . msq("_defaultProduct") . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AddToCartFromStorefrontProductPageActionGroup");
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
		$I->see("$123.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartVerifyCartSubtotalEqualsGrandTotalWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'testProductName" . msq("_defaultProduct") . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1VerifyCartSubtotalEqualsGrandTotal
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageVerifyCartSubtotalEqualsGrandTotal
		$I->see("$123.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalVerifyCartSubtotalEqualsGrandTotal
		$I->see("testProductName" . msq("_defaultProduct"), ".minicart-items"); // stepKey: seeProductNameInMiniCartVerifyCartSubtotalEqualsGrandTotal
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
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditToOpen
		$I->comment("Verify AssertCartPriceRuleConditionIsApplied if condition category id is matching");
		$I->comment("Entering Action Group [cartAssert] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCartAssert
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCartAssert
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCartAssertWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCartAssert
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCartAssertWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCartAssert
		$I->see("$123.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCartAssert
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCartAssert
		$I->waitForText("$5.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCartAssert
		$I->see("$66.50", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCartAssert
		$I->comment("Exiting Action Group [cartAssert] StorefrontCheckCartActionGroup");
		$I->comment("Entering Action Group [seeAssertDiscountAmountAppliedForMatchingCategory] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeAssertDiscountAmountAppliedForMatchingCategory
		$I->see("-$61.50", "td[data-th='Discount']"); // stepKey: assertDiscountSeeAssertDiscountAmountAppliedForMatchingCategory
		$I->comment("Exiting Action Group [seeAssertDiscountAmountAppliedForMatchingCategory] AssertStorefrontCartDiscountActionGroup");
	}
}
