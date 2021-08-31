<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-123: Admin should be able to set Bundle Product as new so that it shows up in the Catalog New Products List Widget")
 * @Description("Admin should be able to set Bundle Product as new so that it shows up in the Catalog New Products List Widget<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/NewProductsListWidgetBundleProductTest.xml<br>app/code/Magento/PageCache/Test/Mftf/Test/NewProductsListWidgetTest/NewProductsListWidgetBundleProductTest.xml<br>")
 * @TestCaseId("MC-123")
 * @group Bundle
 * @group WYSIWYGDisabled
 */
class NewProductsListWidgetBundleProductTestCest
{
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
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
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
	 * @Stories({"New products list widget"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NewProductsListWidgetBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Create a CMS page containing the New Products widget");
		$I->comment("Entering Action Group [amOnCmsList] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnCmsList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCmsList
		$I->comment("Exiting Action Group [amOnCmsList] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickAddNewPageButton] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->click("#add"); // stepKey: clickAddNewPageClickAddNewPageButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewPageClickAddNewPageButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickAddNewPageButton
		$I->comment("Exiting Action Group [clickAddNewPageButton] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->comment("Entering Action Group [fillPageTitle] AdminCmsPageSetTitleActionGroup");
		$I->fillField("input[name=title]", "Test CMS Page" . msq("_newDefaultCmsPage")); // stepKey: fillNewTitleFillPageTitle
		$I->comment("Exiting Action Group [fillPageTitle] AdminCmsPageSetTitleActionGroup");
		$I->comment("Entering Action Group [expandContentSection] AdminExpandContentSectionActionGroup");
		$I->click("div[data-index=content]"); // stepKey: expandContentSectionExpandContentSection
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionExpandContentSection
		$I->comment("Exiting Action Group [expandContentSection] AdminExpandContentSectionActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickInsertWidgetButton] AdminInsertCatalogNewProductListWidgetForCmsPageContentSectionActionGroup");
		$I->click(".action-add-widget"); // stepKey: clickInsertWidgetButtonClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: waitForSlideOutClickInsertWidgetButton
		$I->selectOption("#select_widget_type", "Catalog New Products List"); // stepKey: selectWidgetTypeClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: waitForWidgetOptionsClickInsertWidgetButton
		$I->selectOption("select[name='parameters[display_type]']", "New products"); // stepKey: selectDisplayTypeClickInsertWidgetButton
		$I->selectOption("[name='parameters[show_pager]']", "No"); // stepKey: selectDisplayPageControlClickInsertWidgetButton
		$I->fillField("[name='parameters[products_count]']", "100"); // stepKey: fillNumberOfProductsToDisplayClickInsertWidgetButton
		$I->selectOption("[name='parameters[template]']", "New Products Grid Template"); // stepKey: selectTemplateClickInsertWidgetButton
		$I->fillField("[name='parameters[cache_lifetime]']", ""); // stepKey: fillCacheLifetimeClickInsertWidgetButton
		$I->comment("Exiting Action Group [clickInsertWidgetButton] AdminInsertCatalogNewProductListWidgetForCmsPageContentSectionActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidget
		$I->comment("Exiting Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->comment("Entering Action Group [expandSeoSection] AdminExpandSeoSectionActionGroup");
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: expandSeoSectionExpandSeoSection
		$I->waitForPageLoad(30); // stepKey: expandSeoSectionExpandSeoSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSeoSectionExpandSeoSection
		$I->comment("Exiting Action Group [expandSeoSection] AdminExpandSeoSectionActionGroup");
		$I->comment("Entering Action Group [fillPageUrlKey] AdminCmsPageSetUrlActionGroup");
		$I->fillField("input[name=identifier]", "test-page-" . msq("_newDefaultCmsPage")); // stepKey: fillPageUrlKeyFillPageUrlKey
		$I->comment("Exiting Action Group [fillPageUrlKey] AdminCmsPageSetUrlActionGroup");
		$I->comment("Entering Action Group [clickSaveCmsPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonClickSaveCmsPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageClickSaveCmsPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageClickSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveCmsPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageClickSaveCmsPage
		$I->comment("Exiting Action Group [clickSaveCmsPage] SaveCmsPageActionGroup");
		$I->comment("A Cms page containing the New Products Widget gets created here via extends");
		$I->comment("Create a product to appear in the widget, fill in basic info first");
		$I->comment("Entering Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductList
		$I->comment("Exiting Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickAddBundleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickAddBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickAddBundleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-bundle']"); // stepKey: clickAddProductClickAddBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickAddBundleProduct
		$I->comment("Exiting Action Group [clickAddBundleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Entering Action Group [fillProductName] FillProductNameAndSkuInProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillProductName
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillProductName
		$I->comment("Exiting Action Group [fillProductName] FillProductNameAndSkuInProductFormActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillProductNewFrom] AdminSetProductAsNewDateActionGroup");
		$I->fillField("input[name='product[news_from_date]']", "01/1/2000"); // stepKey: fillProductNewFromFillProductNewFrom
		$I->fillField("input[name='product[news_to_date]']", "01/1/2099"); // stepKey: fillProductNewToFillProductNewFrom
		$I->comment("Exiting Action Group [fillProductNewFrom] AdminSetProductAsNewDateActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("and then configure bundled items for this product");
		$I->scrollTo("button[data-index='add_button']"); // stepKey: scrollToAddOptionButton
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOption
		$I->waitForPageLoad(30); // stepKey: waitForOptions
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "MFTF Test Bundle 1"); // stepKey: fillOptionTitle
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
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "1"); // stepKey: fillProductDefaultQty1
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "1"); // stepKey: fillProductDefaultQty2
		$I->comment("Entering Action Group [clickSaveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Entering Action Group [clearPageCache] ClearPageCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementPageClearPageCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearPageCache
		$I->click("//*[@id='cache_grid_massaction-select']//option[contains(., 'Action')]"); // stepKey: actionSelectionClearPageCache
		$I->waitForPageLoad(30); // stepKey: actionSelectionClearPageCacheWaitForPageLoad
		$I->click("//*[@id='cache_grid_massaction-select']//option[@value='refresh']"); // stepKey: selectRefreshOptionClearPageCache
		$I->waitForPageLoad(30); // stepKey: selectRefreshOptionClearPageCacheWaitForPageLoad
		$I->click("//td[contains(., 'Page Cache')]/..//input[@type='checkbox']"); // stepKey: selectPageCacheRowCheckboxClearPageCache
		$I->click("//button[@title='Submit']"); // stepKey: clickSubmitClearPageCache
		$I->waitForPageLoad(30); // stepKey: clickSubmitClearPageCacheWaitForPageLoad
		$I->comment("Exiting Action Group [clearPageCache] ClearPageCacheActionGroup");
		$I->comment("If PageCache is enabled, Cache clearing happens here, via merge");
		$I->comment("Check for product on the CMS page with the New Products widget");
		$I->comment("Entering Action Group [amOnCmsPage] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//test-page-" . msq("_newDefaultCmsPage")); // stepKey: amOnCmsPageOnStorefrontAmOnCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontAmOnCmsPage
		$I->comment("Exiting Action Group [amOnCmsPage] StorefrontGoToCMSPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeProductName] AssertStorefrontProductIsShownOnCmsPageActionGroup");
		$I->seeInTitle("Test CMS Page" . msq("_newDefaultCmsPage")); // stepKey: seePageTitleSeeProductName
		$I->see("testProductName" . msq("_defaultProduct"), ".product-item-info"); // stepKey: seeProductNameSeeProductName
		$I->comment("Exiting Action Group [seeProductName] AssertStorefrontProductIsShownOnCmsPageActionGroup");
	}
}
