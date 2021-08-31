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
 * @Title("MAGETWO-97370: Check that parent categories are showing products after enabling subcategories after fully reindex")
 * @Description("Check that parent categories are showing products after enabling subcategories after fully reindex<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/ProductAvailableAfterEnablingSubCategoriesTest.xml<br>")
 * @TestCaseId("MAGETWO-97370")
 * @group Catalog
 */
class ProductAvailableAfterEnablingSubCategoriesTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$simpleSubCategoryFields['is_active'] = "false";
		$I->createEntity("simpleSubCategory", "hook", "SubCategoryWithParent", ["createCategory"], $simpleSubCategoryFields); // stepKey: simpleSubCategory
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["simpleSubCategory"], []); // stepKey: createSimpleProduct
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Categories"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ProductAvailableAfterEnablingSubCategoriesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [doNotSeeProductOnCategoryPage] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'name', 'test') . ".html"); // stepKey: navigateToCategoryPageDoNotSeeProductOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadDoNotSeeProductOnCategoryPage
		$I->dontSee($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: assertProductIsNotPresentDoNotSeeProductOnCategoryPage
		$I->comment("Exiting Action Group [doNotSeeProductOnCategoryPage] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [openCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenCreatedSubCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenCreatedSubCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleSubCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenCreatedSubCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenCreatedSubCategory
		$I->comment("Exiting Action Group [openCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [enableCategory] AdminEnableCategoryActionGroup");
		$I->click("input[name='is_active']+label"); // stepKey: enableCategoryEnableCategory
		$I->comment("Exiting Action Group [enableCategory] AdminEnableCategoryActionGroup");
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementSeeSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Run re-index task");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Entering Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomepage
		$I->comment("Exiting Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [openEnabledCategory] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenEnabledCategory
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenEnabledCategory
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenEnabledCategory
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenEnabledCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenEnabledCategory
		$I->comment("Exiting Action Group [openEnabledCategory] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Entering Action Group [seeCreatedProduct] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeCreatedProduct
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeCreatedProduct
		$I->comment("Exiting Action Group [seeCreatedProduct] StorefrontAssertProductNameOnProductMainPageActionGroup");
	}
}
