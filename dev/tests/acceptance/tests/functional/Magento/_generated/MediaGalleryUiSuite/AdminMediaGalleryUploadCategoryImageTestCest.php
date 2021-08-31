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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4836631: User uploads image outside of the Media Gallery")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4836631")
 * @Description("User uploads image outside of the Media Gallery<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryUploadCategoryImageTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryUploadCategoryImageTestCest
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
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
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
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
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
		$I->comment("Entering Action Group [viewContentImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewContentImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewContentImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewContentImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewContentImageDetails
		$I->comment("Exiting Action Group [viewContentImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [deleteCategoryImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'delete')]"); // stepKey: deleteImageDeleteCategoryImage
		$I->waitForElementVisible(".action-accept", 30); // stepKey: waitForConfirmationDeleteCategoryImage
		$I->click(".action-accept"); // stepKey: confirmDeleteDeleteCategoryImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteCategoryImage
		$I->comment("Exiting Action Group [deleteCategoryImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Features({"MediaGalleryUi"})
	 * @Stories({"User uploads image outside of the Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryUploadCategoryImageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkOpenCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory
		$I->comment("Exiting Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [addCategoryImage] AddCategoryImageActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionAddCategoryImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCategoryImage
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyAddCategoryImage
		$I->attachFile(".file-uploader-area>input", "magento-logo.png"); // stepKey: uploadFileAddCategoryImage
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxUploadAddCategoryImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingAddCategoryImage
		$grabCategoryFileNameAddCategoryImage = $I->grabTextFrom(".file-uploader-filename"); // stepKey: grabCategoryFileNameAddCategoryImage
		$I->assertRegExp("/magento-logo(_[0-9]+)*?\.png$/", $grabCategoryFileNameAddCategoryImage, "pass"); // stepKey: assertEqualsAddCategoryImage
		$I->comment("Exiting Action Group [addCategoryImage] AddCategoryImageActionGroup");
		$I->comment("Entering Action Group [saveCategoryForm] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategoryForm
		$I->click("#save"); // stepKey: saveCategorySaveCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategoryForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategoryForm
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategoryForm
		$I->comment("Exiting Action Group [saveCategoryForm] AdminSaveCategoryFormActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromImageUploader] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGalleryFromImageUploader
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGalleryFromImageUploader
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGalleryFromImageUploader
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromImageUploader
		$I->comment("Exiting Action Group [openMediaGalleryFromImageUploader] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [expandCatalogFolder] AdminMediaGalleryExpandFolderActionGroup");
		$I->conditionalClick("#catalog > .jstree-icon", "//li[@id='catalog' and contains(@class,'jstree-closed')]", true); // stepKey: clickArrowIfClosedExpandCatalogFolder
		$I->comment("Exiting Action Group [expandCatalogFolder] AdminMediaGalleryExpandFolderActionGroup");
		$I->comment("Entering Action Group [selectCategoryFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='category']", 30); // stepKey: waitBeforeClickOnFolderSelectCategoryFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='category']"); // stepKey: selectFolderSelectCategoryFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectCategoryFolder
		$I->comment("Exiting Action Group [selectCategoryFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='magento-logo']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertImageInGrid
		$I->comment("Exiting Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
	}
}
