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
 * @Title("MC-224: Admin should be able to set/edit other product information when creating/editing a bundle product")
 * @Description("Admin should be able to set/edit other product information when creating/editing a bundle product<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminCreateAndEditBundleProductSettingsTest.xml<br>")
 * @TestCaseId("MC-224")
 * @group Catalog
 */
class AdminCreateAndEditBundleProductSettingsTestCest
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
		$I->comment("Create a Website");
		$I->createEntity("createWebsite", "hook", "customWebsite", [], []); // stepKey: createWebsite
		$I->comment("Create a simple product for a bundle option");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the simple product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete a Website");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website"); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Second Website", "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
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
	 * @Features({"Bundle"})
	 * @Stories({"Create/Edit bundle product in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateAndEditBundleProductSettingsTest(AcceptanceTester $I)
	{
		$I->comment("Create new bundle product");
		$I->comment("Entering Action Group [createBundleProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateBundleProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateBundleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-bundle']"); // stepKey: clickAddProductCreateBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateBundleProduct
		$I->comment("Exiting Action Group [createBundleProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill all main fields");
		$I->comment("Entering Action Group [fillMainProductFields] FillMainBundleProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillMainProductFields
		$I->fillField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductNameFillMainProductFields
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillMainProductFields
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillMainProductFieldsWaitForPageLoad
		$I->comment("Exiting Action Group [fillMainProductFields] FillMainBundleProductFormActionGroup");
		$I->comment("Add the bundle option to the product");
		$I->comment("Entering Action Group [addBundleOption] AddBundleOptionWithOneProductActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOption
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOption
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOption
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForOptionsAddBundleOption
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "bundle-option-radio" . msq("RadioButtonsOption")); // stepKey: fillTitleAddBundleOption
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "radio"); // stepKey: selectTypeAddBundleOption
		$I->waitForElementVisible("//tr[1]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOption
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWaitForPageLoad
		$I->click("//tr[1]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOption
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOption
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOption
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOption
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOption
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOption
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOption
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOption
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWaitForPageLoad
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOption
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "1"); // stepKey: fillQuantityAddBundleOption
		$I->comment("Exiting Action Group [addBundleOption] AddBundleOptionWithOneProductActionGroup");
		$I->comment("Set product in created Website");
		$I->comment("Entering Action Group [selectProductInWebsites] AdminAssignProductInWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSectionSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionSelectProductInWebsitesWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: expandSectionSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectProductInWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectProductInWebsites
		$I->checkOption("//label[contains(text(), '" . $I->retrieveEntityField('createWebsite', 'website[name]', 'test') . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectProductInWebsites
		$I->comment("Exiting Action Group [selectProductInWebsites] AdminAssignProductInWebsiteActionGroup");
		$I->comment("Set Design settings for the product");
		$I->comment("Entering Action Group [setProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickDesignTabSetProductDesignSettings
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenSetProductDesignSettings
		$I->selectOption("select[name='product[page_layout]']", "3 columns"); // stepKey: setLayoutSetProductDesignSettings
		$I->selectOption("select[name='product[options_container]']", "Block after Info Column"); // stepKey: setDisplayProductOptionsSetProductDesignSettings
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
		$I->amOnPage("/bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert product Design settings \"layout 3 columns\"");
		$I->seeElement(".page-layout-3columns"); // stepKey: seeDesignChanges
		$I->comment("Assert Gift Option product settings is present");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddBundleProductFromProductToCartActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAndAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAndAddToCartAddProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickAddBundleProductToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: clickAddBundleProductToCartAddProductToCartWaitForPageLoad
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 30); // stepKey: waitProductCountAddProductToCart
		$I->see("You added BundleProduct" . msq("BundleProduct") . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddBundleProductFromProductToCartActionGroup");
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
		$I->fillField("input[name=sku]", "bundleproduct" . msq("BundleProduct")); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='bundleproduct" . msq("BundleProduct") . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Assert product in assigned to Website");
		$I->comment("Entering Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "[data-index='websites']._show", false); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->seeCheckboxIsChecked("//label[contains(text(), '" . $I->retrieveEntityField('createWebsite', 'website[name]', 'test') . "')]/parent::div//input[@type='checkbox']"); // stepKey: seeCustomWebsiteIsCheckedSeeCustomWebsiteIsChecked
		$I->comment("Exiting Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->comment("Edit product in Websites");
		$I->comment("Entering Action Group [uncheckProductInWebsites] AdminUnassignProductInWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSectionUncheckProductInWebsites
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionUncheckProductInWebsitesWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: expandSectionUncheckProductInWebsites
		$I->waitForPageLoad(30); // stepKey: expandSectionUncheckProductInWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedUncheckProductInWebsites
		$I->uncheckOption("//label[contains(text(), '" . $I->retrieveEntityField('createWebsite', 'website[name]', 'test') . "')]/parent::div//input[@type='checkbox']"); // stepKey: uncheckWebsiteUncheckProductInWebsites
		$I->comment("Exiting Action Group [uncheckProductInWebsites] AdminUnassignProductInWebsiteActionGroup");
		$I->comment("Edit product Search Engine Optimization settings");
		$I->comment("Entering Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettings
		$I->waitForPageLoad(30); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettingsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenEditProductSEOSettings
		$I->fillField("input[name='product[url_key]']", "Api Bundle Product" . msq("ApiBundleProduct")); // stepKey: setUrlKeyInputEditProductSEOSettings
		$I->fillField("input[name='product[meta_title]']", "Api Bundle Product" . msq("ApiBundleProduct")); // stepKey: setMetaTitleInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_keyword]']", "Api Bundle Product" . msq("ApiBundleProduct")); // stepKey: setMetaKeywordsInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_description]']", "Api Bundle Product" . msq("ApiBundleProduct")); // stepKey: setMetaDescriptionInputEditProductSEOSettings
		$I->comment("Exiting Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->comment("Edit Design settings for the product");
		$I->comment("Entering Action Group [editProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickDesignTabEditProductDesignSettings
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenEditProductDesignSettings
		$I->selectOption("select[name='product[page_layout]']", "2 columns with left bar"); // stepKey: setLayoutEditProductDesignSettings
		$I->selectOption("select[name='product[options_container]']", "Product Info Column"); // stepKey: setDisplayProductOptionsEditProductDesignSettings
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
		$I->amOnPage("/api-bundle-product" . msq("ApiBundleProduct") . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert product design settings \"Layout empty\"");
		$I->seeElement(".page-layout-2columns-left"); // stepKey: seeNewDesignChanges
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
		$I->comment("Delete created bundle product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("bundleproduct" . msq("BundleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
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
