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
 * @Title("MC-217: Admin should be able to mass change bundle products status to Enabled/Disabled")
 * @Description("Admin should be able to mass change bundle products status to Enabled/Disabled<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/MassEnableDisableBundleProductsTest.xml<br>")
 * @TestCaseId("MC-217")
 * @group Bundle
 */
class MassEnableDisableBundleProductsTestCest
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
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
		$I->createEntity("simpleProduct3", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct3
		$I->createEntity("simpleProduct4", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct4
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Clear Filters");
		$I->comment("Entering Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFiltersAfter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfterWaitForPageLoad
		$I->comment("Exiting Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
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
	 * @Stories({"Admin list bundle products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function MassEnableDisableBundleProductsTest(AcceptanceTester $I)
	{
		$I->comment("Go to bundle product creation page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: goToBundleProductCreationPage
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreatePageToLoad
		$I->comment("Create bundle product");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItems
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOption3
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForBundleOptions
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "BundleOption"); // stepKey: fillOptionTitle
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "checkbox"); // stepKey: selectInputType
		$I->comment("Entering Action Group [clickAddProductsToOption] AdminClickAddProductToOptionActionGroup");
		$I->waitForElementVisible("[data-index='modal_set']", 30); // stepKey: waitForAddProductsToBundleClickAddProductsToOption
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsToBundleClickAddProductsToOptionWaitForPageLoad
		$I->click("[data-index='modal_set']"); // stepKey: clickAddProductsToOptionClickAddProductsToOption
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToOptionClickAddProductsToOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterBundleProductsClickAddProductsToOption
		$I->comment("Exiting Action Group [clickAddProductsToOption] AdminClickAddProductToOptionActionGroup");
		$I->comment("Entering Action Group [filterBundleProductOptions] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptions
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptions
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterBundleProductOptions
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptions
		$I->comment("Exiting Action Group [filterBundleProductOptions] FilterProductGridBySkuActionGroup");
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectFirstGridRow
		$I->comment("Entering Action Group [filterBundleProductOptions2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptions2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptions2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptions2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterBundleProductOptions2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptions2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptions2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptions2
		$I->comment("Exiting Action Group [filterBundleProductOptions2] FilterProductGridBySkuActionGroup");
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectFirstGridRow2
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddSelectedBundleProducts
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedBundleProductsWaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "10"); // stepKey: fillProductDefaultQty1
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "10"); // stepKey: fillProductDefaultQty2
		$I->comment("Entering Action Group [createBundledProductForTwoSimpleProducts] AncillaryPrepBundleProductActionGroup");
		$I->comment("PreReq: go to bundle product creation page");
		$I->fillField("//*[@name='product[name]']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameCreateBundledProductForTwoSimpleProducts
		$I->fillField("//*[@name='product[sku]']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuCreateBundledProductForTwoSimpleProducts
		$I->comment("Trigger SEO drop down");
		$I->scrollTo("//div[@data-index='search-engine-optimization']"); // stepKey: moveToSEOSectionCreateBundledProductForTwoSimpleProducts
		$I->conditionalClick("//div[@data-index='search-engine-optimization']", "//input[@name='product[url_key]']", false); // stepKey: openDropDownIfClosedCreateBundledProductForTwoSimpleProducts
		$I->waitForPageLoad(30); // stepKey: openDropDownIfClosedCreateBundledProductForTwoSimpleProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForDropDownSEOCreateBundledProductForTwoSimpleProducts
		$I->comment("Fill URL input");
		$I->fillField("//input[@name='product[url_key]']", "bundleproduct" . msq("BundleProduct")); // stepKey: FillsinSEOlinkExtensionCreateBundledProductForTwoSimpleProducts
		$I->waitForPageLoad(30); // stepKey: FillsinSEOlinkExtensionCreateBundledProductForTwoSimpleProductsWaitForPageLoad
		$I->comment("Exiting Action Group [createBundledProductForTwoSimpleProducts] AncillaryPrepBundleProductActionGroup");
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->seeElement(".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Creating Second bundle product");
		$I->comment("Go to bundle product creation page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: goToBundleProductCreationPage2
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreatePageToLoad2
		$I->comment("Create bundle product 2");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItems2
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOption32
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForBundleOptions2
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "BundleOption"); // stepKey: fillOptionTitle2
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "checkbox"); // stepKey: selectInputType2
		$I->comment("Entering Action Group [clickAddProductsToOption2] AdminClickAddProductToOptionActionGroup");
		$I->waitForElementVisible("[data-index='modal_set']", 30); // stepKey: waitForAddProductsToBundleClickAddProductsToOption2
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsToBundleClickAddProductsToOption2WaitForPageLoad
		$I->click("[data-index='modal_set']"); // stepKey: clickAddProductsToOptionClickAddProductsToOption2
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToOptionClickAddProductsToOption2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterBundleProductsClickAddProductsToOption2
		$I->comment("Exiting Action Group [clickAddProductsToOption2] AdminClickAddProductToOptionActionGroup");
		$I->comment("Entering Action Group [filterBundleProductOptionsx2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptionsx2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsx2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptionsx2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct3', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterBundleProductOptionsx2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptionsx2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsx2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptionsx2
		$I->comment("Exiting Action Group [filterBundleProductOptionsx2] FilterProductGridBySkuActionGroup");
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectFirstGridRowx2
		$I->comment("Entering Action Group [filterBundleProductOptions22] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptions22
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptions22WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptions22
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct4', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterBundleProductOptions22
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptions22
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptions22WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptions22
		$I->comment("Exiting Action Group [filterBundleProductOptions22] FilterProductGridBySkuActionGroup");
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectFirstGridRow22
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddSelectedBundleProducts2
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedBundleProducts2WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "10"); // stepKey: fillProductDefaultQty12
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "10"); // stepKey: fillProductDefaultQty22
		$I->fillField("//*[@name='product[name]']", "BundleProduct2" . msq("BundleProduct")); // stepKey: fillProductName2
		$I->fillField("//*[@name='product[sku]']", "bundleproduct2" . msq("BundleProduct")); // stepKey: fillProductSku2
		$I->comment("Trigger SEO drop down");
		$I->scrollTo("//div[@data-index='search-engine-optimization']"); // stepKey: moveToSEOSection
		$I->conditionalClick("//div[@data-index='search-engine-optimization']", "//input[@name='product[url_key]']", false); // stepKey: openDropDownIfClosed
		$I->waitForPageLoad(30); // stepKey: openDropDownIfClosedWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForDropDownSEO2
		$I->comment("Fill URL input");
		$I->fillField("//input[@name='product[url_key]']", "bundleproduct2" . msq("BundleProduct")); // stepKey: FillsinSEOlinkExtension2
		$I->waitForPageLoad(30); // stepKey: FillsinSEOlinkExtension2WaitForPageLoad
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButton2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton2
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButton2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton2
		$I->comment("Exiting Action Group [clickSaveButton2] AdminProductFormSaveActionGroup");
		$I->see("You saved the product."); // stepKey: messageYouSavedTheProductIsShown2
		$I->comment("Clear Filters");
		$I->comment("Entering Action Group [ClearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [ClearFilters] AdminClearFiltersActionGroup");
		$I->comment("Setting filter");
		$I->comment("Entering Action Group [FilterForOnlyBundleProducts] BundleProductFilter");
		$I->comment("Setting filter");
		$I->comment("PreReq: go to admin product catalog page");
		$I->click("//div[@class='data-grid-filters-action-wrap']/button"); // stepKey: ClickOnFilterFilterForOnlyBundleProducts
		$I->waitForPageLoad(30); // stepKey: ClickOnFilterFilterForOnlyBundleProductsWaitForPageLoad
		$I->click("//select[@name='type_id']"); // stepKey: ClickOnTypeDropDownFilterForOnlyBundleProducts
		$I->waitForPageLoad(30); // stepKey: ClickOnTypeDropDownFilterForOnlyBundleProductsWaitForPageLoad
		$I->click("//select[@name='type_id']/option[@value='bundle']"); // stepKey: ClickOnBundleOptionFilterForOnlyBundleProducts
		$I->waitForPageLoad(30); // stepKey: ClickOnBundleOptionFilterForOnlyBundleProductsWaitForPageLoad
		$I->click("//button[@class='action-secondary']"); // stepKey: ClickOnApplyFiltersFilterForOnlyBundleProducts
		$I->waitForPageLoad(30); // stepKey: ClickOnApplyFiltersFilterForOnlyBundleProductsWaitForPageLoad
		$I->comment("Exiting Action Group [FilterForOnlyBundleProducts] BundleProductFilter");
		$I->comment("Disabling bundle products");
		$I->click("//div[@data-role='grid-wrapper']//label[@data-bind='attr: {for: ko.uid}']"); // stepKey: ClickOnSelectAllCheckBox
		$I->waitForPageLoad(30); // stepKey: ClickOnSelectAllCheckBoxWaitForPageLoad
		$I->click("//div[@class='action-select-wrap']/button"); // stepKey: ClickOnActions
		$I->waitForPageLoad(30); // stepKey: ClickOnActionsWaitForPageLoad
		$I->click("//div[@class='action-menu-items']//li[2]"); // stepKey: ClickOnChangeStatus
		$I->waitForPageLoad(30); // stepKey: ClickOnChangeStatusWaitForPageLoad
		$I->click("//div[@class='action-menu-items']//ul[@class='action-submenu _active']//li[span='Disable']"); // stepKey: ClickOnDisable
		$I->waitForPageLoad(30); // stepKey: ClickOnDisableWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageloadToExecute
		$runCronReindex = $I->magentoCron("index", 90); // stepKey: runCronReindex
		$I->comment($runCronReindex);
		$I->comment("Entering Action Group [clearing] ClearPageCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementPageClearing
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearing
		$I->click("//*[@id='cache_grid_massaction-select']//option[contains(., 'Action')]"); // stepKey: actionSelectionClearing
		$I->waitForPageLoad(30); // stepKey: actionSelectionClearingWaitForPageLoad
		$I->click("//*[@id='cache_grid_massaction-select']//option[@value='refresh']"); // stepKey: selectRefreshOptionClearing
		$I->waitForPageLoad(30); // stepKey: selectRefreshOptionClearingWaitForPageLoad
		$I->click("//td[contains(., 'Page Cache')]/..//input[@type='checkbox']"); // stepKey: selectPageCacheRowCheckboxClearing
		$I->click("//button[@title='Submit']"); // stepKey: clickSubmitClearing
		$I->waitForPageLoad(30); // stepKey: clickSubmitClearingWaitForPageLoad
		$I->comment("Exiting Action Group [clearing] ClearPageCacheActionGroup");
		$I->comment("Confirm bundle products have been disabled");
		$I->amOnPage("bundleproduct2" . msq("BundleProduct") . ".html"); // stepKey: GoToProductPage
		$I->waitForPageLoad(30); // stepKey: WaitForProductPageToLoadToShowElement
		$I->dontSeeElement("//*[@id='maincontent']//span[@itemprop='name']"); // stepKey: LookingForNameOfProductDisabled
		$I->comment("Enabling bundle products");
		$I->comment("Entering Action Group [goToCatalogPageChangingView] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToCatalogPageChangingView
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToCatalogPageChangingView
		$I->comment("Exiting Action Group [goToCatalogPageChangingView] AdminProductCatalogPageOpenActionGroup");
		$I->click("//div[@data-role='grid-wrapper']//label[@data-bind='attr: {for: ko.uid}']"); // stepKey: ClickOnSelectAllCheckBoxChangingView
		$I->waitForPageLoad(30); // stepKey: ClickOnSelectAllCheckBoxChangingViewWaitForPageLoad
		$I->click("//div[@class='action-select-wrap']/button"); // stepKey: ClickOnActionsChangingView
		$I->waitForPageLoad(30); // stepKey: ClickOnActionsChangingViewWaitForPageLoad
		$I->click("//div[@class='action-menu-items']//li[2]"); // stepKey: ClickOnChangeStatusChangingView
		$I->waitForPageLoad(30); // stepKey: ClickOnChangeStatusChangingViewWaitForPageLoad
		$I->click("//div[@class='action-menu-items']//ul[@class='action-submenu _active']//li[span='Enable']"); // stepKey: ClickOnEnable
		$I->waitForPageLoad(30); // stepKey: ClickOnEnableWaitForPageLoad
		$I->comment("Clear Cache - reindex - resets products according to enabled/disabled view");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Confirm bundle products have been enabled");
		$I->amOnPage("bundleproduct2" . msq("BundleProduct") . ".html"); // stepKey: GoToProductPageEnabled
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductPageToLoad
		$I->seeElement("//*[@id='maincontent']//span[@itemprop='name']"); // stepKey: LookingForNameOfProduct
	}
}
