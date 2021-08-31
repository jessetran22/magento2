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
 * @Title("MAGETWO-58718: Product image assignment for multiple stores")
 * @Description("Product image assignment for multiple stores<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductImageAssignmentForMultipleStoresTest.xml<br>")
 * @TestCaseId("MAGETWO-58718")
 * @group product
 * @group WYSIWYGDisabled
 */
class AdminProductImageAssignmentForMultipleStoresTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create Store View English");
		$I->comment("Entering Action Group [createStoreViewEn] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreViewEn
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreViewEn
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateStoreViewEn
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateStoreViewEn
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreViewEn
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreViewEn
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewEnWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreViewEn
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewEnWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreViewEn
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreViewEn
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewEnWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreViewEn
		$I->comment("Exiting Action Group [createStoreViewEn] AdminCreateStoreViewActionGroup");
		$I->comment("Create Store View France");
		$I->comment("Entering Action Group [createStoreViewFr] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreViewFr
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreViewFr
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: enterStoreViewNameCreateStoreViewFr
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: enterStoreViewCodeCreateStoreViewFr
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreViewFr
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreViewFr
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewFrWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreViewFr
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewFrWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreViewFr
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreViewFr
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewFrWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreViewFr
		$I->comment("Exiting Action Group [createStoreViewFr] AdminCreateStoreViewActionGroup");
		$I->comment("Create Category and Simple Product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createSimpleProductFields['price'] = "100";
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], $createSimpleProductFields); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Store View English");
		$I->comment("Entering Action Group [deleteStoreViewEn] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreViewEn
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewEnWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewFilterFieldDeleteStoreViewEn
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewEnWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewEnWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreViewEn
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewEnWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreViewEn
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewEnWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreViewEn
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreViewEn
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewEnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreViewEn
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreViewEn
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreViewEn
		$I->comment("Exiting Action Group [deleteStoreViewEn] AdminDeleteStoreViewActionGroup");
		$I->comment("Delete Store View France");
		$I->comment("Entering Action Group [deleteStoreViewFr] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreViewFr
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewFrWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewFilterFieldDeleteStoreViewFr
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewFrWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewFrWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreViewFr
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewFrWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreViewFr
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewFrWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreViewFr
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreViewFr
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewFrWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreViewFr
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreViewFr
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreViewFr
		$I->comment("Exiting Action Group [deleteStoreViewFr] AdminDeleteStoreViewActionGroup");
		$I->comment("Clear Filter Store");
		$I->comment("Entering Action Group [resetFiltersOnStorePage] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetFiltersOnStorePage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetFiltersOnStorePageWaitForPageLoad
		$I->comment("Exiting Action Group [resetFiltersOnStorePage] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Delete Category and Simple Product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Clear Filter Product");
		$I->comment("Entering Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->comment("Logout Admin");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Product image assignment for multiple stores"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductImageAssignmentForMultipleStoresTest(AcceptanceTester $I)
	{
		$I->comment("Search Product and Open Edit");
		$I->comment("Entering Action Group [searchProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Switch to the English store view");
		$I->comment("Entering Action Group [switchStoreViewEnglishProduct] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchStoreViewEnglishProduct
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchStoreViewEnglishProduct
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchStoreViewEnglishProductWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'EN" . msq("customStoreEN") . "')]"); // stepKey: clickStoreViewByNameSwitchStoreViewEnglishProduct
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchStoreViewEnglishProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchStoreViewEnglishProduct
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchStoreViewEnglishProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchStoreViewEnglishProduct
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchStoreViewEnglishProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchStoreViewEnglishProduct
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchStoreViewEnglishProduct
		$I->see("EN" . msq("customStoreEN"), ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchStoreViewEnglishProduct
		$I->comment("Exiting Action Group [switchStoreViewEnglishProduct] AdminSwitchStoreViewActionGroup");
		$I->comment("Upload Image English");
		$I->comment("Entering Action Group [uploadImageEnglish] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionUploadImageEnglish
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshUploadImageEnglish
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyUploadImageEnglish
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileUploadImageEnglish
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadUploadImageEnglish
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailUploadImageEnglish
		$I->comment("Exiting Action Group [uploadImageEnglish] AddProductImageActionGroup");
		$I->comment("Entering Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->comment("Switch to the French store view");
		$I->comment("Entering Action Group [switchStoreViewFrenchProduct] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchStoreViewFrenchProduct
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchStoreViewFrenchProduct
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchStoreViewFrenchProductWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'FR" . msq("customStoreFR") . "')]"); // stepKey: clickStoreViewByNameSwitchStoreViewFrenchProduct
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchStoreViewFrenchProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchStoreViewFrenchProduct
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchStoreViewFrenchProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchStoreViewFrenchProduct
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchStoreViewFrenchProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchStoreViewFrenchProduct
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchStoreViewFrenchProduct
		$I->see("FR" . msq("customStoreFR"), ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchStoreViewFrenchProduct
		$I->comment("Exiting Action Group [switchStoreViewFrenchProduct] AdminSwitchStoreViewActionGroup");
		$I->comment("Upload Image French");
		$I->comment("Entering Action Group [uploadImageFrench] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionUploadImageFrench
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshUploadImageFrench
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyUploadImageFrench
		$I->attachFile("#fileupload", "magento3.jpg"); // stepKey: uploadFileUploadImageFrench
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadUploadImageFrench
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento3')]", 30); // stepKey: waitForThumbnailUploadImageFrench
		$I->comment("Exiting Action Group [uploadImageFrench] AddProductImageActionGroup");
		$I->comment("Entering Action Group [assignImageRole1] AdminAssignImageRolesActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "//*[@id='media_gallery_content']//img[contains(@src, 'magento3')]", false); // stepKey: expandImagesAssignImageRole1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento3')]", 30); // stepKey: seeProductImageNameAssignImageRole1
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, 'magento3')]"); // stepKey: clickProductImageAssignImageRole1
		$I->waitForElementVisible("textarea[data-role='image-description']", 30); // stepKey: seeAltTextSectionAssignImageRole1
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']"); // stepKey: checkRoleBaseAssignImageRole1
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']"); // stepKey: checkRoleSmallAssignImageRole1
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']"); // stepKey: checkRoleThumbnailAssignImageRole1
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']"); // stepKey: checkRoleSwatchAssignImageRole1
		$I->click(".modal-slide._show [data-role=\"closeBtn\"]"); // stepKey: clickCloseButtonAssignImageRole1
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonAssignImageRole1WaitForPageLoad
		$I->comment("Exiting Action Group [assignImageRole1] AdminAssignImageRolesActionGroup");
		$I->comment("Entering Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->comment("Switch to the All store view");
		$I->comment("Entering Action Group [switchAllStoreViewProduct] AdminSwitchToAllStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchAllStoreViewProduct
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchAllStoreViewProduct
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchAllStoreViewProductWaitForPageLoad
		$I->click(".store-switcher .store-switcher-all"); // stepKey: clickStoreViewByNameSwitchAllStoreViewProduct
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchAllStoreViewProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchAllStoreViewProduct
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchAllStoreViewProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchAllStoreViewProduct
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchAllStoreViewProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchAllStoreViewProduct
		$I->see("All Store Views", ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchAllStoreViewProduct
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchAllStoreViewProduct
		$I->comment("Exiting Action Group [switchAllStoreViewProduct] AdminSwitchToAllStoreViewActionGroup");
		$I->comment("Upload Image All Store View");
		$I->comment("Entering Action Group [uploadImageAllStoreView] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionUploadImageAllStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshUploadImageAllStoreView
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyUploadImageAllStoreView
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileUploadImageAllStoreView
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadUploadImageAllStoreView
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailUploadImageAllStoreView
		$I->comment("Exiting Action Group [uploadImageAllStoreView] AddProductImageActionGroup");
		$I->comment("Entering Action Group [assignImageRole] AdminAssignImageRolesActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", false); // stepKey: expandImagesAssignImageRole
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: seeProductImageNameAssignImageRole
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]"); // stepKey: clickProductImageAssignImageRole
		$I->waitForElementVisible("textarea[data-role='image-description']", 30); // stepKey: seeAltTextSectionAssignImageRole
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']"); // stepKey: checkRoleBaseAssignImageRole
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']"); // stepKey: checkRoleSmallAssignImageRole
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']"); // stepKey: checkRoleThumbnailAssignImageRole
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']"); // stepKey: checkRoleSwatchAssignImageRole
		$I->click(".modal-slide._show [data-role=\"closeBtn\"]"); // stepKey: clickCloseButtonAssignImageRole
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonAssignImageRoleWaitForPageLoad
		$I->comment("Exiting Action Group [assignImageRole] AdminAssignImageRolesActionGroup");
		$I->comment("Change any product data product description");
		$I->click("div[data-index='content']"); // stepKey: openDescriptionDropDown
		$I->waitForPageLoad(30); // stepKey: openDescriptionDropDownWaitForPageLoad
		$I->fillField("#product_form_description", "This is the long description"); // stepKey: fillLongDescription
		$I->fillField("#product_form_short_description", "This is the short description"); // stepKey: fillShortDescription
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
		$I->comment("Go to Product Page and see Default Store View");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToDefaultStorefrontProductPage
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='magento-again']", 30); // stepKey: waitImageToBeLoaded
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento-again']"); // stepKey: seeActiveImageDefault
		$I->comment("English Switch Store View and see English Store View");
		$I->comment("Entering Action Group [switchStoreViewEnglish] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStoreViewEnglish
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStoreViewEnglish
		$I->click("li.view-en" . msq("customStoreEN") . ">a"); // stepKey: clickSelectStoreViewSwitchStoreViewEnglish
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStoreViewEnglish
		$I->comment("Exiting Action Group [switchStoreViewEnglish] StorefrontSwitchStoreViewActionGroup");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: openCategoryPage
		$I->waitForPageLoad(30); // stepKey: openCategoryPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPage
		$I->seeElement(".products-grid img[src*='magento-logo']"); // stepKey: seeThumb
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]"); // stepKey: openProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='magento-logo']", 30); // stepKey: waitImageToBeLoaded2
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento-logo']"); // stepKey: seeActiveImageEnglish
		$I->comment("Switch France Store View and see France Store View");
		$I->comment("Entering Action Group [switchStoreViewFrance] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStoreViewFrance
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStoreViewFrance
		$I->click("li.view-fr" . msq("customStoreFR") . ">a"); // stepKey: clickSelectStoreViewSwitchStoreViewFrance
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStoreViewFrance
		$I->comment("Exiting Action Group [switchStoreViewFrance] StorefrontSwitchStoreViewActionGroup");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: openCategoryPage1
		$I->waitForPageLoad(30); // stepKey: openCategoryPage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPage1
		$I->seeElement(".products-grid img[src*='magento3']"); // stepKey: seeThumb1
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]"); // stepKey: openProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductPage1
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='magento3']", 30); // stepKey: waitImageToBeLoaded3
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento3']"); // stepKey: seeActiveImageFrance
	}
}
