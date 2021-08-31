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
 * @Title("MAGETWO-96722: Check that cart rules applied for product in cart")
 * @Description("Check that cart rules applied for product in cart<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminCartRulesAppliedForProductInCartTest.xml<br>")
 * @TestCaseId("MAGETWO-96722")
 * @group SalesRule
 */
class AdminCartRulesAppliedForProductInCartTestCest
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
		$I->comment("Create category and product");
		$I->createEntity("defaultCategory", "hook", "_defaultCategory", [], []); // stepKey: defaultCategory
		$simpleProductFields['price'] = "200";
		$simpleProductFields['quantity'] = "500";
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], $simpleProductFields); // stepKey: simpleProduct
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
		$I->comment("Delete created data");
		$I->deleteEntity("defaultCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [deleteBundleProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteBundleProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteBundleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteBundleProduct
		$I->fillField("input.admin__control-text[name='sku']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFilterDeleteBundleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteBundleProductWaitForPageLoad
		$I->see("bundleproduct" . msq("BundleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteBundleProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteBundleProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteBundleProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteBundleProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteBundleProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteBundleProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteBundleProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteBundleProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteBundleProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteBundleProduct
		$I->comment("Exiting Action Group [deleteBundleProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteCartPriceRule
		$I->fillField("input[name='name']", "SalesRule" . msq("PriceRuleWithCondition")); // stepKey: filterByNameDeleteCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteCartPriceRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCartPriceRule] DeleteCartPriceRuleByName");
		$I->comment("Entering Action Group [clearFilters1] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters1
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilters1WaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters1] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"The cart rule cannot effect the cart"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCartRulesAppliedForProductInCartTest(AcceptanceTester $I)
	{
		$I->comment("Start creating a bundle product");
		$I->comment("Entering Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductList
		$I->comment("Exiting Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-bundle']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-bundle']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillNameAndSku] FillProductNameAndSkuInProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFillNameAndSku
		$I->fillField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillNameAndSku
		$I->comment("Exiting Action Group [fillNameAndSku] FillProductNameAndSkuInProductFormActionGroup");
		$I->pressKey(".admin__field[data-index=sku] input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: enter
		$I->comment("Off dynamic price and set value");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageToSeePriceTypeElement
		$I->click("//div[@data-index='price_type']//div[@data-role='switcher']"); // stepKey: offDynamicPrice
		$I->waitForPageLoad(30); // stepKey: offDynamicPriceWaitForPageLoad
		$I->fillField("//div[@data-index='price']//input", "0"); // stepKey: setProductPrice
		$I->comment("Add category to product");
		$I->click("//div[@data-index='category_ids']//div[@class='admin__field-control']"); // stepKey: dropDownCategories
		$I->waitForPageLoad(30); // stepKey: dropDownCategoriesWaitForPageLoad
		$I->fillField("div.action-menu._active > div.admin__action-multiselect-search-wrap input", $I->retrieveEntityField('defaultCategory', 'name', 'test')); // stepKey: searchForCategory
		$I->waitForPageLoad(30); // stepKey: searchForCategoryWaitForPageLoad
		$I->waitForElementVisible("//div[@class='action-menu _active']//label[@class='admin__action-multiselect-label']", 30); // stepKey: waitForElementLoaded
		$I->waitForPageLoad(30); // stepKey: waitForElementLoadedWaitForPageLoad
		$I->click("//div[@class='action-menu _active']//label[@class='admin__action-multiselect-label']"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->click("//div[@class='action-menu _active']//button[@data-action='close-advanced-select']"); // stepKey: clickOnCategoriesLabelToCloseOptions
		$I->comment("Add option, a \"Radio Buttons\" type option, with one product and set fixed price 200");
		$I->comment("Entering Action Group [addBundleOptionWithOneProduct] AddBundleOptionWithOneProductActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithOneProduct
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithOneProduct
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithOneProduct
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithOneProduct
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "Option One"); // stepKey: fillTitleAddBundleOptionWithOneProduct
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "radio"); // stepKey: selectTypeAddBundleOptionWithOneProduct
		$I->waitForElementVisible("//tr[1]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithOneProductWaitForPageLoad
		$I->click("//tr[1]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithOneProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithOneProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithOneProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithOneProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithOneProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithOneProduct
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithOneProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithOneProductWaitForPageLoad
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithOneProductWaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "1"); // stepKey: fillQuantityAddBundleOptionWithOneProduct
		$I->comment("Exiting Action Group [addBundleOptionWithOneProduct] AddBundleOptionWithOneProductActionGroup");
		$I->selectOption("bundle_options[bundle_options][0][bundle_selections][0][selection_price_type]", "Fixed"); // stepKey: selectPriceType
		$I->fillField("bundle_options[bundle_options][0][bundle_selections][0][selection_price_value]", "200"); // stepKey: fillPriceValue
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
		$I->comment("Create cart price rule");
		$I->comment("Entering Action Group [createRule] AdminCreateCartPriceRuleWithConditionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateRule
		$I->click("#add"); // stepKey: clickAddNewRuleCreateRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateRuleWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateRule
		$I->fillField("input[name='name']", "SalesRule" . msq("PriceRuleWithCondition")); // stepKey: fillRuleNameCreateRule
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateRule
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN',  'General',  'Wholesale',  'Retailer']); // stepKey: selectCustomerGroupCreateRule
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateRule
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateRuleWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Fixed amount discount for whole cart"); // stepKey: selectActionTypeCreateRule
		$I->click("div[data-index='conditions']"); // stepKey: openConditionsSectionCreateRule
		$I->waitForPageLoad(30); // stepKey: openConditionsSectionCreateRuleWaitForPageLoad
		$I->click("//*[@id='conditions__1__children']//span"); // stepKey: addFirstConditionCreateRule
		$I->selectOption("rule[conditions][1][new_child]", "Products subselection"); // stepKey: selectRuleCreateRule
		$I->waitForElementVisible("//span[@class='rule-param']/a[contains(text(), 'is')]", 30); // stepKey: waitForFirstRuleElementCreateRule
		$I->click("//span[@class='rule-param']/a[contains(text(), 'is')]"); // stepKey: clickToChangeRuleCreateRule
		$I->selectOption("rule[conditions][1--1][operator]", "equals or greater than"); // stepKey: selectRule1CreateRule
		$I->waitForElementVisible("//span[@class='rule-param']/a[contains(text(), '...')]", 30); // stepKey: waitForSecondRuleElementCreateRule
		$I->click("//span[@class='rule-param']/a[contains(text(), '...')]"); // stepKey: clickToChangeRule1CreateRule
		$I->fillField("rule[conditions][1--1][value]", "2"); // stepKey: fillRuleCreateRule
		$I->click("//*[@id='conditions__1--1__children']//span"); // stepKey: addSecondConditionCreateRule
		$I->selectOption("rule[conditions][1--1][new_child]", "Category"); // stepKey: selectSecondConditionCreateRule
		$I->waitForElementVisible("//span[@class='rule-param']/a[contains(text(), '...')]", 30); // stepKey: waitForThirdRuleElementCreateRule
		$I->click("//span[@class='rule-param']/a[contains(text(), '...')]"); // stepKey: addThirdConditionCreateRule
		$I->waitForElementVisible("//label[@for='conditions__1--1--1__value']", 30); // stepKey: waitForForthRuleElementCreateRule
		$I->click("//label[@for='conditions__1--1--1__value']"); // stepKey: openChooserCreateRule
		$I->waitForElementVisible("//span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]/parent::a/preceding-sibling::input[@type='checkbox']", 30); // stepKey: waitForCategoryVisibleCreateRule
		$I->checkOption("//span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]/parent::a/preceding-sibling::input[@type='checkbox']"); // stepKey: checkCategoryNameCreateRule
		$I->click("#save"); // stepKey: clickSaveButtonCreateRule
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateRule
		$I->comment("Go to Conditions section");
		$I->comment("Exiting Action Group [createRule] AdminCreateCartPriceRuleWithConditionsActionGroup");
		$I->comment("Go to Storefront and add product to cart and checkout from cart");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->fillField("#qty", "2"); // stepKey: setQuantity
		$I->comment("Entering Action Group [AddProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCard
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCardWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCard
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCard
		$I->see("You added " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCard
		$I->comment("Exiting Action Group [AddProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutFillingShipping
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShipping
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShipping
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShipping
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShipping
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShipping
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShipping
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShipping
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShipping
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShipping
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShipping
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShipping
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShipping
		$I->comment("Exiting Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Check totals");
		$grabSubtotal = $I->grabTextFrom("//tr[@class='totals sub']//span[@class='price']"); // stepKey: grabSubtotal
		$grabShippingTotal = $I->grabTextFrom("//tr[@class='totals shipping excl']//span[@class='price']"); // stepKey: grabShippingTotal
		$grabTotal = $I->grabTextFrom("//tr[@class='grand totals']//span[@class='price']"); // stepKey: grabTotal
		$I->assertEquals("$400.00", $grabSubtotal); // stepKey: assertSubtotal
		$I->assertEquals("$10.00", $grabShippingTotal); // stepKey: assertShippingTotal
		$I->assertEquals("$410.00", $grabTotal); // stepKey: assertTotal
	}
}
