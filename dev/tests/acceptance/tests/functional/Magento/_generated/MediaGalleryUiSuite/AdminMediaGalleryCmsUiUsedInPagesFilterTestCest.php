<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4934276: Used in pages filter")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4934276")
 * @Description("User filters assets used in pages<h3>Test files</h3>app/code/Magento/MediaGalleryCmsUi/Test/Mftf/Test/AdminMediaGalleryCmsUiUsedInPagesFilterTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCmsUiUsedInPagesFilterTestCest
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
        $this->helperContainer->create("Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	 * @Features({"MediaGalleryCmsUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCmsUiUsedInPagesFilterTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToCreateNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToCreateNewPage
		$I->comment("Exiting Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Entering Action Group [fillBasicPageDataForPageWithDefaultStore] FillOutCustomCMSPageContentActionGroup");
		$I->fillField("input[name=title]", "Unique page title MediaGalleryUi"); // stepKey: fillFieldTitleFillBasicPageDataForPageWithDefaultStore
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillBasicPageDataForPageWithDefaultStore
		$I->fillField("input[name=content_heading]", "MediaGalleryUI content"); // stepKey: fillFieldContentHeadingFillBasicPageDataForPageWithDefaultStore
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillBasicPageDataForPageWithDefaultStore
		$I->fillField("#cms_page_form_content", "MediaGalleryUI content"); // stepKey: fillFieldContentFillBasicPageDataForPageWithDefaultStore
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForPageWithDefaultStore
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForPageWithDefaultStoreWaitForPageLoad
		$I->fillField("input[name=identifier]", "test-page-1"); // stepKey: fillFieldUrlKeyFillBasicPageDataForPageWithDefaultStore
		$I->comment("Exiting Action Group [fillBasicPageDataForPageWithDefaultStore] FillOutCustomCMSPageContentActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: clickExpandContentOpenMediaGalleryForPage
		$I->waitForElementVisible(".scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImageButtonOpenMediaGalleryForPage
		$I->scrollTo(".scalable.action-add-image.plugin", 0, -80); // stepKey: scrollToInsertImageButtonOpenMediaGalleryForPage
		$I->click(".scalable.action-add-image.plugin"); // stepKey: clickInsertImageOpenMediaGalleryForPage
		$I->comment("wait for initial media gallery load, where the gallery chrome loads (and triggers loading modal)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGalleryInitialLoadOpenMediaGalleryForPage
		$I->comment("wait for second media gallery load, where the gallery images load (and triggers loading modal once more)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGallerySecondaryLoadOpenMediaGalleryForPage
		$I->comment("Exiting Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [selectContentImageInGrid] AdminMediaGalleryClickImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleSelectContentImageInGrid
		$I->click("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']"); // stepKey: clickOnImageSelectContentImageInGrid
		$I->comment("Exiting Action Group [selectContentImageInGrid] AdminMediaGalleryClickImageInGridActionGroup");
		$I->comment("Entering Action Group [clickAddSelectedContentImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->waitForElementVisible(".media-gallery-add-selected", 30); // stepKey: waitForAddSelectedButtonClickAddSelectedContentImage
		$I->click(".media-gallery-add-selected"); // stepKey: ClickAddSelectedClickAddSelectedContentImage
		$I->waitForPageLoad(30); // stepKey: waitForImageToBeAddedClickAddSelectedContentImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearClickAddSelectedContentImage
		$I->comment("Exiting Action Group [clickAddSelectedContentImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->click("#save-button"); // stepKey: savePage
		$I->waitForPageLoad(10); // stepKey: savePageWaitForPageLoad
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->click("//div[label/span[contains(text(), 'Used in Pages')]]//div[@class='action-select admin__action-multiselect']"); // stepKey: openFilterSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: openFilterSetUsedInFilterWaitForPageLoad
		$I->fillField("//div[label/span[contains(text(), 'Used in Pages')]]//input[@data-role='advanced-select-text']", "Unique page title MediaGalleryUi"); // stepKey: enterOptionNameSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: enterOptionNameSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Pages')]]//label[@class='admin__action-multiselect-label']/span[text()='Unique page title MediaGalleryUi']"); // stepKey: selectOptionSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: selectOptionSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Pages')]]//button[@data-action='close-advanced-select']"); // stepKey: clickDoneSetUsedInFilter
		$I->comment("Exiting Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertImageInGrid
		$I->comment("Exiting Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->comment("Entering Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->waitForElementVisible("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']", 30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->see("Default View", "div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->comment("Exiting Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->wait(5); // stepKey: waitBeforeEnableMassActionToDeleteImages
		$I->waitForElementVisible("#delete_massaction", 30); // stepKey: waitForMassActionButtonEnableMassActionToDeleteImages
		$I->click("#delete_massaction"); // stepKey: clickOnMassActionButtonEnableMassActionToDeleteImages
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedEnableMassActionToDeleteImages
		$I->wait(5); // stepKey: waitAfterEnableMassActionToDeleteImages
		$I->comment("Exiting Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->comment("Entering Action Group [selectFirstImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->checkOption("//input[@type='checkbox'][@data-ui-id ='Title of the magento image']"); // stepKey: selectImageInGridToDelteSelectFirstImageToDelete
		$I->comment("Exiting Action Group [selectFirstImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->comment("Entering Action Group [clickDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->click("#delete_selected_massaction"); // stepKey: clickDeleteImagesClickDeleteSelectedButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeleteModalClickDeleteSelectedButton
		$I->comment("Exiting Action Group [clickDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->comment("Entering Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->click(".media-gallery-delete-image-action .action-accept"); // stepKey: confirmDeleteDeleteImages
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeletingProccesDeleteImages
		$I->comment("Exiting Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->comment("Entering Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCmsPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsPageGrid
		$I->comment("Exiting Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [findCreatedCmsPage] AdminSearchCmsPageInGridByUrlKeyActionGroup");
		$I->click("//button[text()='Filters']"); // stepKey: clickFilterButtonFindCreatedCmsPage
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", "test-page-1"); // stepKey: fillUrlKeyFieldFindCreatedCmsPage
		$I->click("//span[text()='Apply Filters']"); // stepKey: clickApplyFiltersButtonFindCreatedCmsPage
		$I->waitForPageLoad(60); // stepKey: clickApplyFiltersButtonFindCreatedCmsPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingFindCreatedCmsPage
		$I->comment("Exiting Action Group [findCreatedCmsPage] AdminSearchCmsPageInGridByUrlKeyActionGroup");
		$I->comment("Entering Action Group [deleteCmsPage] AdminDeleteCmsPageFromGridActionGroup");
		$I->click("//div[text()='test-page-1']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeleteCmsPage
		$I->click("//div[text()='test-page-1']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeleteCmsPage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeleteCmsPage
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeleteCmsPageWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeleteCmsPage
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteCmsPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteCmsPage
		$I->comment("Exiting Action Group [deleteCmsPage] AdminDeleteCmsPageFromGridActionGroup");
		$I->comment("Entering Action Group [clickApplyFiltersButton] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClickApplyFiltersButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickApplyFiltersButton] ClearFiltersAdminDataGridActionGroup");
	}
}
