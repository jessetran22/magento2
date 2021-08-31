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
 * @Title("MC-26119: Product Categories Indexer in Update on Schedule mode")
 * @Description("The test verifies that in Update on Schedule mode if displaying of category products on Storefront changes due to product properties change,             the changes are NOT applied immediately, but applied only after cron runs (twice).<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductCategoryIndexerInUpdateOnScheduleModeTest.xml<br>")
 * @TestCaseId("MC-26119")
 * @group catalog
 * @group indexer
 */
class AdminProductCategoryIndexerInUpdateOnScheduleModeTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create category A without products");
		$I->createEntity("createCategoryA", "hook", "_defaultCategory", [], []); // stepKey: createCategoryA
		$I->comment("Create product A1 not assigned to any category");
		$I->createEntity("createProductA1", "hook", "simpleProductWithoutCategory", [], []); // stepKey: createProductA1
		$I->comment("Create anchor category B with subcategory C");
		$I->createEntity("createCategoryB", "hook", "_defaultCategory", [], []); // stepKey: createCategoryB
		$I->createEntity("createCategoryC", "hook", "SubCategoryWithParent", ["createCategoryB"], []); // stepKey: createCategoryC
		$I->comment("Assign product B1 to category B");
		$I->createEntity("createProductB1", "hook", "ApiSimpleProduct", ["createCategoryB"], []); // stepKey: createProductB1
		$I->comment("Assign product C1 to category C");
		$I->createEntity("createProductC1", "hook", "ApiSimpleProduct", ["createCategoryC"], []); // stepKey: createProductC1
		$I->comment("Assign product C2 to category C");
		$I->createEntity("createProductC2", "hook", "ApiSimpleProduct", ["createCategoryC"], []); // stepKey: createProductC2
		$I->comment("Switch indexers to \"Update by Schedule\" mode");
		$I->comment("Entering Action Group [onUpdateBySchedule] AdminSwitchAllIndexerToActionModeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: onIndexManagementOnUpdateBySchedule
		$I->waitForPageLoad(30); // stepKey: waitForManagementPageOnUpdateBySchedule
		$I->selectOption("#gridIndexer_massaction-mass-select", "selectAll"); // stepKey: checkIndexerOnUpdateBySchedule
		$I->selectOption("#gridIndexer_massaction-select", "Update by Schedule"); // stepKey: selectActionOnUpdateBySchedule
		$I->click("#gridIndexer_massaction-form button"); // stepKey: clickSubmitOnUpdateBySchedule
		$I->waitForPageLoad(30); // stepKey: waitForSubmitOnUpdateBySchedule
		$I->see("indexer(s) are in \"Update by Schedule\" mode."); // stepKey: seeMessageOnUpdateBySchedule
		$I->comment("Exiting Action Group [onUpdateBySchedule] AdminSwitchAllIndexerToActionModeActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Switch indexers to \"Update on Save\" mode");
		$I->comment("Entering Action Group [onUpdateOnSave] AdminSwitchAllIndexerToActionModeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: onIndexManagementOnUpdateOnSave
		$I->waitForPageLoad(30); // stepKey: waitForManagementPageOnUpdateOnSave
		$I->selectOption("#gridIndexer_massaction-mass-select", "selectAll"); // stepKey: checkIndexerOnUpdateOnSave
		$I->selectOption("#gridIndexer_massaction-select", "Update on Save"); // stepKey: selectActionOnUpdateOnSave
		$I->click("#gridIndexer_massaction-form button"); // stepKey: clickSubmitOnUpdateOnSave
		$I->waitForPageLoad(30); // stepKey: waitForSubmitOnUpdateOnSave
		$I->see("indexer(s) are in \"Update on Save\" mode."); // stepKey: seeMessageOnUpdateOnSave
		$I->comment("Exiting Action Group [onUpdateOnSave] AdminSwitchAllIndexerToActionModeActionGroup");
		$I->comment("Delete data");
		$I->deleteEntity("createProductA1", "hook"); // stepKey: deleteProductA1
		$I->deleteEntity("createProductB1", "hook"); // stepKey: deleteProductB1
		$I->deleteEntity("createProductC1", "hook"); // stepKey: deleteProductC1
		$I->deleteEntity("createProductC2", "hook"); // stepKey: deleteProductC2
		$I->deleteEntity("createCategoryA", "hook"); // stepKey: deleteCategoryA
		$I->deleteEntity("createCategoryC", "hook"); // stepKey: deleteCategoryC
		$I->deleteEntity("createCategoryB", "hook"); // stepKey: deleteCategoryB
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
	 * @Stories({"Product Categories Indexer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductCategoryIndexerInUpdateOnScheduleModeTest(AcceptanceTester $I)
	{
		$I->comment("Case: change product category from product page");
		$I->comment("1. Open Admin > Catalog > Products > Product A1");
		$I->comment("Entering Action Group [goToProductA1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductA1', 'id', 'test')); // stepKey: goToProductGoToProductA1
		$I->comment("Exiting Action Group [goToProductA1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("2. Assign category A to product A1. Save product");
		$I->comment("Entering Action Group [assignProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDownAssignProduct
		$I->waitForPageLoad(30); // stepKey: openDropDownAssignProductWaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('createCategoryA', 'name', 'test') . "')]"); // stepKey: selectCategoryAssignProduct
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignProductWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDoneAssignProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneAssignProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryAssignProduct
		$I->click("#save-button"); // stepKey: clickSaveAssignProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveAssignProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingProductAssignProduct
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageAssignProduct
		$I->comment("Exiting Action Group [assignProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("3. Open category A on Storefront");
		$I->comment("Entering Action Group [goToCategoryA] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoToCategoryA
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToCategoryA
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryA', 'name', 'test') . "')]]"); // stepKey: toCategoryGoToCategoryA
		$I->waitForPageLoad(30); // stepKey: toCategoryGoToCategoryAWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoToCategoryA
		$I->comment("Exiting Action Group [goToCategoryA] StorefrontGoToCategoryPageActionGroup");
		$I->comment("The category is still empty");
		$I->see($I->retrieveEntityField('createCategoryA', 'name', 'test'), "#page-title-heading span"); // stepKey: seeCategoryA1Name
		$I->comment("Entering Action Group [seeEmptyNotice] AssertStorefrontNoProductsFoundActionGroup");
		$I->see("We can't find products matching the selection."); // stepKey: seeEmptyNoticeSeeEmptyNotice
		$I->comment("Exiting Action Group [seeEmptyNotice] AssertStorefrontNoProductsFoundActionGroup");
		$I->dontSee($I->retrieveEntityField('createProductA1', 'name', 'test'), ".product-item-name"); // stepKey: dontseeProductA1
		$I->comment("4. Run cron to reindex");
		$I->wait(60); // stepKey: waitForChanges
		$runCron = $I->magentoCLI("cron:run", 60); // stepKey: runCron
		$I->comment($runCron);
		$I->comment("5. Open category A on Storefront again");
		$I->comment("Entering Action Group [reloadCategoryA] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadCategoryA
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadCategoryA
		$I->comment("Exiting Action Group [reloadCategoryA] ReloadPageActionGroup");
		$I->comment("Category A displays product A1 now");
		$I->see($I->retrieveEntityField('createCategoryA', 'name', 'test'), "#page-title-heading span"); // stepKey: seeTitleCategoryA1
		$I->see($I->retrieveEntityField('createProductA1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductA1
		$I->comment("6.  Open Admin > Catalog > Products > Product A1. Unassign category A from product A1");
		$I->comment("Entering Action Group [OnPageProductA1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductA1', 'id', 'test')); // stepKey: goToProductOnPageProductA1
		$I->comment("Exiting Action Group [OnPageProductA1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductA1PageLoad
		$I->comment("Entering Action Group [unassignCategoryA] AdminUnassignCategoryOnProductAndSaveActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("//span[@class='admin__action-multiselect-crumb']/span[contains(.,'" . $I->retrieveEntityField('createCategoryA', 'name', 'test') . "')]/../button[@data-action='remove-selected-item']"); // stepKey: clearCategoryUnassignCategoryA
		$I->waitForPageLoad(30); // stepKey: clearCategoryUnassignCategoryAWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteUnassignCategoryA
		$I->click("#save-button"); // stepKey: clickSaveUnassignCategoryA
		$I->waitForPageLoad(30); // stepKey: clickSaveUnassignCategoryAWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingProductUnassignCategoryA
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageUnassignCategoryA
		$I->comment("Exiting Action Group [unassignCategoryA] AdminUnassignCategoryOnProductAndSaveActionGroup");
		$I->comment("7. Open category A on Storefront");
		$I->comment("Entering Action Group [toCategoryA] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendToCategoryA
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadToCategoryA
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryA', 'name', 'test') . "')]]"); // stepKey: toCategoryToCategoryA
		$I->waitForPageLoad(30); // stepKey: toCategoryToCategoryAWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToCategoryA
		$I->comment("Exiting Action Group [toCategoryA] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category A still contains product A1");
		$I->see($I->retrieveEntityField('createCategoryA', 'name', 'test'), "#page-title-heading span"); // stepKey: seeCategoryAOnPage
		$I->see($I->retrieveEntityField('createProductA1', 'name', 'test'), ".product-item-name"); // stepKey: seeNameProductA1
		$I->comment("8. Run cron reindex (Ensure that at least one minute passed since last cron run)");
		$I->wait(60); // stepKey: waitOneMinute
		$runCron1 = $I->magentoCLI("cron:run", 60); // stepKey: runCron1
		$I->comment($runCron1);
		$I->comment("9. Open category A on Storefront again");
		$I->comment("Entering Action Group [refreshCategoryAPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshCategoryAPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshCategoryAPage
		$I->comment("Exiting Action Group [refreshCategoryAPage] ReloadPageActionGroup");
		$I->comment("Category A is empty now");
		$I->see($I->retrieveEntityField('createCategoryA', 'name', 'test'), "#page-title-heading span"); // stepKey: seeOnPageCategoryAName
		$I->comment("Entering Action Group [seeOnPageEmptyNotice] AssertStorefrontNoProductsFoundActionGroup");
		$I->see("We can't find products matching the selection."); // stepKey: seeEmptyNoticeSeeOnPageEmptyNotice
		$I->comment("Exiting Action Group [seeOnPageEmptyNotice] AssertStorefrontNoProductsFoundActionGroup");
		$I->dontSee($I->retrieveEntityField('createProductA1', 'name', 'test'), ".product-item-name"); // stepKey: dontseeProductA1OnPage
		$I->comment("Case: change product status");
		$I->comment("10. Open category B on Storefront");
		$I->comment("Entering Action Group [toCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendToCategoryB
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadToCategoryB
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryToCategoryB
		$I->waitForPageLoad(30); // stepKey: toCategoryToCategoryBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToCategoryB
		$I->comment("Exiting Action Group [toCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category B displays product B1, C1 and C2");
		$I->see($I->retrieveEntityField('createCategoryB', 'name', 'test'), "#page-title-heading span"); // stepKey: seeCategoryBOnPage
		$I->see($I->retrieveEntityField('createProductB1', 'name', 'test'), ".product-item-name"); // stepKey: seeNameProductB1
		$I->see($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: seeNameProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeNameProductC2
		$I->comment("11. Open product C1 in Admin. Make it disabled (Enable Product = No)");
		$I->comment("Entering Action Group [goToProductC1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductC1', 'id', 'test')); // stepKey: goToProductGoToProductC1
		$I->comment("Exiting Action Group [goToProductC1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductC1PageLoad
		$I->click("input[name='product[status]']+label"); // stepKey: clickOffEnableToggleAgain
		$I->comment("Saved successfully");
		$I->comment("Entering Action Group [saveProductC1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductC1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductC1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductC1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductC1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductC1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductC1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductC1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductC1
		$I->comment("Exiting Action Group [saveProductC1] SaveProductFormActionGroup");
		$I->comment("12. Open category B on Storefront");
		$I->comment("Entering Action Group [toCategoryBStorefront] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendToCategoryBStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadToCategoryBStorefront
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryToCategoryBStorefront
		$I->waitForPageLoad(30); // stepKey: toCategoryToCategoryBStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToCategoryBStorefront
		$I->comment("Exiting Action Group [toCategoryBStorefront] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category B displays product B1, C1 and C2");
		$I->see($I->retrieveEntityField('createCategoryB', 'name', 'test'), "#page-title-heading span"); // stepKey: categoryBOnPage
		$I->see($I->retrieveEntityField('createProductB1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductB1
		$I->see($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeProductC2
		$I->comment("13. Open category C on Storefront");
		$I->comment("Entering Action Group [goToCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoToCategoryC
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToCategoryC
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryGoToCategoryC
		$I->waitForPageLoad(30); // stepKey: toCategoryGoToCategoryCWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: openSubCategoryGoToCategoryC
		$I->waitForPageLoad(30); // stepKey: openSubCategoryGoToCategoryCWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoToCategoryC
		$I->comment("Exiting Action Group [goToCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Category C still displays products C1 and C2");
		$I->see($I->retrieveEntityField('createCategoryC', 'name', 'test'), "#page-title-heading span"); // stepKey: categoryCOnPage
		$I->see($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductC1inCategoryC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeProductC2InCategoryC2
		$I->comment("14. Run cron to reindex  (Ensure that at least one minute passed since last cron run)");
		$I->wait(60); // stepKey: waitMinute
		$runCron2 = $I->magentoCLI("cron:run", 60); // stepKey: runCron2
		$I->comment($runCron2);
		$I->comment("15. Open category B on Storefront");
		$I->comment("Entering Action Group [onPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOnPageCategoryB
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOnPageCategoryB
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryOnPageCategoryB
		$I->waitForPageLoad(30); // stepKey: toCategoryOnPageCategoryBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOnPageCategoryB
		$I->comment("Exiting Action Group [onPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category B displays product B1 and C2 only");
		$I->see($I->retrieveEntityField('createCategoryB', 'name', 'test'), "#page-title-heading span"); // stepKey: seeTitleCategoryBOnPage
		$I->see($I->retrieveEntityField('createProductB1', 'name', 'test'), ".product-item-name"); // stepKey: seeOnCategoryBPageProductB1
		$I->dontSee($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeOnCategoryBPageProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeOnCategoryBPageProductC2
		$I->comment("16. Open category C on Storefront");
		$I->comment("Entering Action Group [openCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategoryC
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategoryC
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenCategoryC
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryCWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: openSubCategoryOpenCategoryC
		$I->waitForPageLoad(30); // stepKey: openSubCategoryOpenCategoryCWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategoryC
		$I->comment("Exiting Action Group [openCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Category C displays only product C2 now");
		$I->see($I->retrieveEntityField('createCategoryC', 'name', 'test'), "#page-title-heading span"); // stepKey: seeTitleOnCategoryCPage
		$I->dontSee($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeOnCategoryCPageProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeOnCategoryCPageProductC2
		$I->comment("17. Repeat steps 10-16, but enable products instead.");
		$I->comment("17.11 Open product C1 in Admin. Make it enabled");
		$I->comment("Entering Action Group [goToEditProductC1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductC1', 'id', 'test')); // stepKey: goToProductGoToEditProductC1
		$I->comment("Exiting Action Group [goToEditProductC1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductC1Page
		$I->click("input[name='product[status]']+label"); // stepKey: clickOnEnableToggleAgain
		$I->comment("Saved successfully");
		$I->comment("Entering Action Group [saveChangedProductC1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveChangedProductC1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveChangedProductC1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveChangedProductC1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveChangedProductC1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveChangedProductC1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveChangedProductC1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveChangedProductC1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveChangedProductC1
		$I->comment("Exiting Action Group [saveChangedProductC1] SaveProductFormActionGroup");
		$I->comment("17.12. Open category B on Storefront");
		$I->comment("Entering Action Group [openCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategoryB
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategoryB
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenCategoryB
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategoryB
		$I->comment("Exiting Action Group [openCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category B displays product B1 and C2");
		$I->see($I->retrieveEntityField('createCategoryB', 'name', 'test'), "#page-title-heading span"); // stepKey: titleCategoryBOnPage
		$I->see($I->retrieveEntityField('createProductB1', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryBPageProductB1
		$I->dontSee($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryBPageProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryBPageProductC2
		$I->comment("17.13. Open category C on Storefront");
		$I->comment("Entering Action Group [openToCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenToCategoryC
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenToCategoryC
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenToCategoryC
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenToCategoryCWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: openSubCategoryOpenToCategoryC
		$I->waitForPageLoad(30); // stepKey: openSubCategoryOpenToCategoryCWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenToCategoryC
		$I->comment("Exiting Action Group [openToCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Category C displays product C2");
		$I->see($I->retrieveEntityField('createCategoryC', 'name', 'test'), "#page-title-heading span"); // stepKey: titleOnCategoryCPage
		$I->dontSee($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryCPageProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryCPageProductC2
		$I->comment("17.14. Run cron to reindex  (Ensure that at least one minute passed since last cron run)");
		$I->wait(60); // stepKey: waitForOneMinute
		$runCron3 = $I->magentoCLI("cron:run", 60); // stepKey: runCron3
		$I->comment($runCron3);
		$I->comment("17.15. Open category B on Storefront");
		$I->comment("Entering Action Group [openPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenPageCategoryB
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenPageCategoryB
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenPageCategoryB
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenPageCategoryBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenPageCategoryB
		$I->comment("Exiting Action Group [openPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category B displays products B1, C1, C2 again, but only after reindex.");
		$I->see($I->retrieveEntityField('createCategoryB', 'name', 'test'), "#page-title-heading span"); // stepKey: onPageSeeCategoryBTitle
		$I->see($I->retrieveEntityField('createProductB1', 'name', 'test'), ".product-item-name"); // stepKey: onPageSeeCategoryBProductB1
		$I->see($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: onPageSeeCategoryBProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: onPageSeeCategoryBProductC2
		$I->comment("17.16. Open category C on Storefront");
		$I->comment("Entering Action Group [openOnStorefrontCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenOnStorefrontCategoryC
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenOnStorefrontCategoryC
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenOnStorefrontCategoryC
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenOnStorefrontCategoryCWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: openSubCategoryOpenOnStorefrontCategoryC
		$I->waitForPageLoad(30); // stepKey: openSubCategoryOpenOnStorefrontCategoryCWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenOnStorefrontCategoryC
		$I->comment("Exiting Action Group [openOnStorefrontCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Category C displays products C1, C2 again, but only after reindex.");
		$I->see($I->retrieveEntityField('createCategoryC', 'name', 'test'), "#page-title-heading span"); // stepKey: onPageSeeCategoryCTitle
		$I->see($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: onPageSeeCategoryCProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: onPageSeeCategoryCProductC2
		$I->comment("Case: change product visibility");
		$I->comment("18. Repeat steps 10-17 but change product Visibility instead of product status");
		$I->comment("18.11 Open product C1 in Admin. Make it enabled");
		$I->comment("Entering Action Group [editProductC1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductC1', 'id', 'test')); // stepKey: goToProductEditProductC1
		$I->comment("Exiting Action Group [editProductC1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitProductC1Page
		$I->selectOption("//select[@name='product[visibility]']", "Search"); // stepKey: changeVisibility
		$I->comment("Saved successfully");
		$I->comment("Entering Action Group [productC1Saved] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductProductC1Saved
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonProductC1Saved
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonProductC1SavedWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductProductC1Saved
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductC1SavedWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageProductC1Saved
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageProductC1Saved
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationProductC1Saved
		$I->comment("Exiting Action Group [productC1Saved] SaveProductFormActionGroup");
		$I->comment("18.12. Open category B on Storefront");
		$I->comment("Entering Action Group [goPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoPageCategoryB
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoPageCategoryB
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryGoPageCategoryB
		$I->waitForPageLoad(30); // stepKey: toCategoryGoPageCategoryBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoPageCategoryB
		$I->comment("Exiting Action Group [goPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category B displays products B1, C1, C2 again, but only after reindex.");
		$I->see($I->retrieveEntityField('createCategoryB', 'name', 'test'), "#page-title-heading span"); // stepKey: seeCategoryBTitle
		$I->see($I->retrieveEntityField('createProductB1', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryBProductB1
		$I->see($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryBProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryBProductC2
		$I->comment("18.13. Open category C on Storefront");
		$I->comment("Entering Action Group [goPageCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoPageCategoryC
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoPageCategoryC
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryGoPageCategoryC
		$I->waitForPageLoad(30); // stepKey: toCategoryGoPageCategoryCWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: openSubCategoryGoPageCategoryC
		$I->waitForPageLoad(30); // stepKey: openSubCategoryGoPageCategoryCWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoPageCategoryC
		$I->comment("Exiting Action Group [goPageCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Category C displays products C1, C2 again, but only after reindex.");
		$I->see($I->retrieveEntityField('createCategoryC', 'name', 'test'), "#page-title-heading span"); // stepKey: seeCategoryCTitle
		$I->see($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: seeOnCategoryCProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeOnCategoryCProductC2
		$I->comment("18.14. Run cron to reindex  (Ensure that at least one minute passed since last cron run)");
		$I->wait(60); // stepKey: waitExtraMinute
		$runCron4 = $I->magentoCLI("cron:run", 60); // stepKey: runCron4
		$I->comment($runCron4);
		$I->comment("18.15. Open category B on Storefront");
		$I->comment("Entering Action Group [navigateToPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendNavigateToPageCategoryB
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadNavigateToPageCategoryB
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryNavigateToPageCategoryB
		$I->waitForPageLoad(30); // stepKey: toCategoryNavigateToPageCategoryBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageNavigateToPageCategoryB
		$I->comment("Exiting Action Group [navigateToPageCategoryB] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Category B displays product B1 and C2 only");
		$I->see($I->retrieveEntityField('createCategoryB', 'name', 'test'), "#page-title-heading span"); // stepKey: seeTitleCategoryB
		$I->see($I->retrieveEntityField('createProductB1', 'name', 'test'), ".product-item-name"); // stepKey: seeTitleProductB1
		$I->dontSee($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: dontseeCategoryBProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeTitleProductC2
		$I->comment("18.18. Open category C on Storefront");
		$I->comment("Entering Action Group [navigateToPageCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendNavigateToPageCategoryC
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadNavigateToPageCategoryC
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: toCategoryNavigateToPageCategoryC
		$I->waitForPageLoad(30); // stepKey: toCategoryNavigateToPageCategoryCWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: openSubCategoryNavigateToPageCategoryC
		$I->waitForPageLoad(30); // stepKey: openSubCategoryNavigateToPageCategoryCWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageNavigateToPageCategoryC
		$I->comment("Exiting Action Group [navigateToPageCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Category C displays product C2 again, but only after reindex.");
		$I->see($I->retrieveEntityField('createCategoryC', 'name', 'test'), "#page-title-heading span"); // stepKey: seeTitleCategoryC
		$I->dontSee($I->retrieveEntityField('createProductC1', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeOnCategoryCProductC1
		$I->see($I->retrieveEntityField('createProductC2', 'name', 'test'), ".product-item-name"); // stepKey: seeOnPageTitleProductC2
	}
}
