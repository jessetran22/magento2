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
 * @Title("MC-124: Admin should be able to set Downloadable Product as new so that it shows up in the Catalog New Products List Widget")
 * @Description("Admin should be able to set Downloadable Product as new so that it shows up in the Catalog New Products List Widget<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/NewProductsListWidgetDownloadableProductTest.xml<br>app/code/Magento/PageCache/Test/Mftf/Test/NewProductsListWidgetTest/NewProductsListWidgetDownloadableProductTest.xml<br>")
 * @TestCaseId("MC-124")
 * @group Downloadable
 * @group WYSIWYGDisabled
 */
class NewProductsListWidgetDownloadableProductTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
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
	 * @Features({"Downloadable"})
	 * @Stories({"New products list widget"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NewProductsListWidgetDownloadableProductTest(AcceptanceTester $I)
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
		$I->comment("Create a Downloadable product to appear in the widget");
		$I->comment("Entering Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductList
		$I->comment("Exiting Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickAddDownloadableProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickAddDownloadableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickAddDownloadableProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-downloadable']"); // stepKey: clickAddProductClickAddDownloadableProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickAddDownloadableProduct
		$I->comment("Exiting Action Group [clickAddDownloadableProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Entering Action Group [fillProductName] FillMainDownloadableProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductSkuFillProductName
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductNameFillProductName
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductName
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductName
		$I->comment("Exiting Action Group [fillProductName] FillMainDownloadableProductFormActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillProductNewFrom] AdminSetProductAsNewDateActionGroup");
		$I->fillField("input[name='product[news_from_date]']", "01/1/2000"); // stepKey: fillProductNewFromFillProductNewFrom
		$I->fillField("input[name='product[news_to_date]']", "01/1/2099"); // stepKey: fillProductNewToFillProductNewFrom
		$I->comment("Exiting Action Group [fillProductNewFrom] AdminSetProductAsNewDateActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->click("div[data-index='downloadable']"); // stepKey: openDownloadableSection
		$I->waitForPageLoad(30); // stepKey: openDownloadableSectionWaitForPageLoad
		$I->checkOption("input[name='is_downloadable']"); // stepKey: checkIsDownloadable
		$I->fillField("input[name='product[links_title]']", "This Is A Title"); // stepKey: fillDownloadableLinkTitle
		$I->checkOption("input[name='product[links_purchased_separately]']"); // stepKey: checkLinksPurchasedSeparately
		$I->fillField("input[name='product[samples_title]']", "This Is Another Title"); // stepKey: fillDownloadableSampleTitle
		$I->comment("Entering Action Group [addDownloadableLinkWithMaxDownloads] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddDownloadableLinkWithMaxDownloads
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][title]']", "Downloadable" . msq("downloadableLinkWithMaxDownloads")); // stepKey: fillDownloadableLinkTitleAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][price]']", "1.00"); // stepKey: fillDownloadableLinkPriceAddDownloadableLinkWithMaxDownloads
		$I->selectOption("select[name='downloadable[link][0][type]']", "Upload File"); // stepKey: selectDownloadableLinkFileTypeAddDownloadableLinkWithMaxDownloads
		$I->selectOption("select[name='downloadable[link][0][sample][type]']", "URL"); // stepKey: selectDownloadableLinkSampleTypeAddDownloadableLinkWithMaxDownloads
		$I->selectOption("select[name='downloadable[link][0][is_shareable]']", "Yes"); // stepKey: selectDownloadableLinkShareableAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][number_of_downloads]']", "100"); // stepKey: fillDownloadableLinkMaxDownloadsAddDownloadableLinkWithMaxDownloads
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='0'] fieldset[data-index='container_file'] input[type='file']", "magento-logo.png"); // stepKey: fillDownloadableLinkUploadFileAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][sample][url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkSampleUrlAddDownloadableLinkWithMaxDownloads
		$I->comment("Exiting Action Group [addDownloadableLinkWithMaxDownloads] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
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
