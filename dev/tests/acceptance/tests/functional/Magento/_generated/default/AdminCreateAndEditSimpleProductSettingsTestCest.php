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
 * @Title("MC-3241: Admin should be able to set/edit other product information when creating/editing a simple product")
 * @Description("Admin should be able to set/edit product information when creating/editing a simple product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateAndEditSimpleProductSettingsTest.xml<br>")
 * @TestCaseId("MC-3241")
 * @group Catalog
 */
class AdminCreateAndEditSimpleProductSettingsTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
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
		$I->comment("Create related products");
		$I->createEntity("createFirstRelatedProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstRelatedProduct
		$I->createEntity("createSecondRelatedProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondRelatedProduct
		$I->createEntity("createThirdRelatedProduct", "hook", "SimpleProduct2", [], []); // stepKey: createThirdRelatedProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete related products");
		$I->deleteEntity("createFirstRelatedProduct", "hook"); // stepKey: deleteFirstRelatedProduct
		$I->deleteEntity("createSecondRelatedProduct", "hook"); // stepKey: deleteSecondRelatedProduct
		$I->deleteEntity("createThirdRelatedProduct", "hook"); // stepKey: deleteThirdRelatedProduct
		$I->comment("Log out");
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
	 * @Features({"Catalog"})
	 * @Stories({"Create/Edit simple product in Admin"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateAndEditSimpleProductSettingsTest(AcceptanceTester $I)
	{
		$I->comment("Create new simple product");
		$I->comment("Entering Action Group [createSimpleProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateSimpleProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateSimpleProduct
		$I->comment("Exiting Action Group [createSimpleProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill all main fields");
		$I->comment("Entering Action Group [fillAllNecessaryFields] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillAllNecessaryFields
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillAllNecessaryFields
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillAllNecessaryFields
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillAllNecessaryFields
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillAllNecessaryFields
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillAllNecessaryFields
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillAllNecessaryFieldsWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillAllNecessaryFields
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillAllNecessaryFields
		$I->comment("Exiting Action Group [fillAllNecessaryFields] FillMainProductFormActionGroup");
		$I->comment("Add two related products");
		$I->comment("Entering Action Group [addFirstRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddFirstRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddFirstRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddFirstRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddFirstRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddFirstRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstRelatedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddFirstRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddFirstRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddFirstRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddFirstRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddFirstRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddFirstRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addFirstRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [addSecondRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddSecondRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddSecondRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddSecondRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddSecondRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddSecondRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSecondRelatedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddSecondRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddSecondRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddSecondRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddSecondRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddSecondRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddSecondRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addSecondRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Set Design settings for the product");
		$I->comment("Entering Action Group [setProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickDesignTabSetProductDesignSettings
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenSetProductDesignSettings
		$I->selectOption("select[name='product[page_layout]']", "2 columns with left bar"); // stepKey: setLayoutSetProductDesignSettings
		$I->selectOption("select[name='product[options_container]']", "Product Info Column"); // stepKey: setDisplayProductOptionsSetProductDesignSettings
		$I->comment("Exiting Action Group [setProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->comment("Set Gift Options settings for the product");
		$I->comment("Entering Action Group [enableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->click("div[data-index='gift-options']"); // stepKey: clickToExpandGiftOptionsTabEnableGiftMessageSettings
		$I->waitForPageLoad(30); // stepKey: waitForGiftOptionsOpenEnableGiftMessageSettings
		$I->uncheckOption("[name='product[use_config_gift_message_available]']"); // stepKey: uncheckConfigSettingsMessageEnableGiftMessageSettings
		$I->click("input[name='product[gift_message_available]']+label"); // stepKey: clickToGiftMessageSwitcherEnableGiftMessageSettings
		$I->waitForElementVisible("input[name='product[gift_message_available]'][value='1']", 30); // stepKey: assertGiftMessageStatusEnableGiftMessageSettings
		$I->comment("Exiting Action Group [enableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->comment("Save product form");
		$I->comment("Entering Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveButton
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveButtonWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveButton
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveButton
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->comment("Open product page");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert related products at the storefront");
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createFirstRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeFirstRelatedProductInStorefront
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createSecondRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeSecondRelatedProductInStorefront
		$I->comment("Assert product design settings \"left bar is present at product page with 2 columns\"");
		$I->seeElement(".page-layout-2columns-left"); // stepKey: seeDesignChanges
		$I->comment("Assert Gift Option product settings is present");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added testProductName" . msq("_defaultProduct") . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenShoppingCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenShoppingCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenShoppingCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenShoppingCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenShoppingCartWaitForPageLoad
		$I->comment("Exiting Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [assertGiftMessageFieldsArePresent] StorefrontAssertGiftMessageFieldsActionGroup");
		$I->waitForElementVisible(".action.action-gift", 30); // stepKey: waitForCartGiftOptionVisibleAssertGiftMessageFieldsArePresent
		$I->click(".action.action-gift"); // stepKey: clickGiftOptionBtnAssertGiftMessageFieldsArePresent
		$I->seeElement(".gift-options-content .field-to input"); // stepKey: seeFieldToAssertGiftMessageFieldsArePresent
		$I->seeElement(".gift-options-content .field-from input"); // stepKey: seeFieldFromAssertGiftMessageFieldsArePresent
		$I->seeElement("#gift-message-whole-message"); // stepKey: seeMessageAreaAssertGiftMessageFieldsArePresent
		$I->seeElement(".action-update"); // stepKey: seeUpdateButtonAssertGiftMessageFieldsArePresent
		$I->seeElement(".action-cancel"); // stepKey: seeCancelButtonAssertGiftMessageFieldsArePresent
		$I->comment("Exiting Action Group [assertGiftMessageFieldsArePresent] StorefrontAssertGiftMessageFieldsActionGroup");
		$I->comment("Open created product");
		$I->comment("Entering Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", "testSku" . msq("_defaultProduct")); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='testSku" . msq("_defaultProduct") . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Edit product Search Engine Optimization settings");
		$I->comment("Entering Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettings
		$I->waitForPageLoad(30); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettingsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenEditProductSEOSettings
		$I->fillField("input[name='product[url_key]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setUrlKeyInputEditProductSEOSettings
		$I->fillField("input[name='product[meta_title]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setMetaTitleInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_keyword]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setMetaKeywordsInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_description]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setMetaDescriptionInputEditProductSEOSettings
		$I->comment("Exiting Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->comment("Edit related products");
		$I->comment("Entering Action Group [addThirdRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddThirdRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddThirdRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddThirdRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddThirdRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddThirdRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createThirdRelatedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddThirdRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddThirdRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddThirdRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddThirdRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddThirdRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddThirdRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addThirdRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->click("//span[text()='Related Products']//..//..//..//span[text()='" . $I->retrieveEntityField('createFirstRelatedProduct', 'sku', 'test') . "']//..//..//..//..//..//button[@class='action-delete']"); // stepKey: removeFirstRelatedProduct
		$I->comment("Edit Design settings for the product");
		$I->comment("Entering Action Group [editProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickDesignTabEditProductDesignSettings
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenEditProductDesignSettings
		$I->selectOption("select[name='product[page_layout]']", "Empty"); // stepKey: setLayoutEditProductDesignSettings
		$I->selectOption("select[name='product[options_container]']", "Block after Info Column"); // stepKey: setDisplayProductOptionsEditProductDesignSettings
		$I->comment("Exiting Action Group [editProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->comment("Edit Gift Option product settings");
		$I->comment("Entering Action Group [disableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->click("div[data-index='gift-options']"); // stepKey: clickToExpandGiftOptionsTabDisableGiftMessageSettings
		$I->waitForPageLoad(30); // stepKey: waitForGiftOptionsOpenDisableGiftMessageSettings
		$I->uncheckOption("[name='product[use_config_gift_message_available]']"); // stepKey: uncheckConfigSettingsMessageDisableGiftMessageSettings
		$I->click("input[name='product[gift_message_available]']+label"); // stepKey: clickToGiftMessageSwitcherDisableGiftMessageSettings
		$I->waitForElementVisible("input[name='product[gift_message_available]'][value='0']", 30); // stepKey: assertGiftMessageStatusDisableGiftMessageSettings
		$I->comment("Exiting Action Group [disableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->comment("Save product form");
		$I->comment("Entering Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->comment("Verify Url Key after changing");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/simple-product-" . msq("SimpleProduct") . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert related products at the storefront");
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createSecondRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeSecondRelatedProduct
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createThirdRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeThirdRelatedProduct
		$I->comment("Assert product design settings \"Layout empty\"");
		$I->seeElement(".page-layout-empty"); // stepKey: seeNewDesignChanges
		$I->comment("Assert Gift Option product settings");
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
		$I->dontSeeElement(".action.action-gift"); // stepKey: dontSeeGiftOptionBtn
		$I->comment("Delete created simple product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
	}
}
