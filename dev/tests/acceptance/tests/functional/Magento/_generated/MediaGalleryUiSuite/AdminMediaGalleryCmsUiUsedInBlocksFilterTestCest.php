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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951850: Used in blocks filter")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951850")
 * @Description("User filters assets used in blocks<h3>Test files</h3>app/code/Magento/MediaGalleryCmsUi/Test/Mftf/Test/AdminMediaGalleryCmsUiUsedInBlocksFilterTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCmsUiUsedInBlocksFilterTestCest
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
		$I->createEntity("block", "hook", "_defaultBlock", [], []); // stepKey: block
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
		$I->deleteEntity("block", "hook"); // stepKey: deleteBlock
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
	 * @Features({"MediaGalleryCmsUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCmsUiUsedInBlocksFilterTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('block', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('block', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage1
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->click(".scalable.action-add-image.plugin"); // stepKey: clickInsertImageIcon
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
		$I->click("#save-button"); // stepKey: saveBlock
		$I->waitForPageLoad(10); // stepKey: saveBlockWaitForPageLoad
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->click("//div[label/span[contains(text(), 'Used in Blocks')]]//div[@class='action-select admin__action-multiselect']"); // stepKey: openFilterSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: openFilterSetUsedInFilterWaitForPageLoad
		$I->fillField("//div[label/span[contains(text(), 'Used in Blocks')]]//input[@data-role='advanced-select-text']", $I->retrieveEntityField('block', 'title', 'test')); // stepKey: enterOptionNameSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: enterOptionNameSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Blocks')]]//label[@class='admin__action-multiselect-label']/span[text()='" . $I->retrieveEntityField('block', 'title', 'test') . "']"); // stepKey: selectOptionSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: selectOptionSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Blocks')]]//button[@data-action='close-advanced-select']"); // stepKey: clickDoneSetUsedInFilter
		$I->comment("Exiting Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertImageInGrid
		$I->comment("Exiting Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
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
		$I->comment("Entering Action Group [clikDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->click("#delete_selected_massaction"); // stepKey: clickDeleteImagesClikDeleteSelectedButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeleteModalClikDeleteSelectedButton
		$I->comment("Exiting Action Group [clikDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->comment("Entering Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->click(".media-gallery-delete-image-action .action-accept"); // stepKey: confirmDeleteDeleteImages
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeletingProccesDeleteImages
		$I->comment("Exiting Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
	}
}
