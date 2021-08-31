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
 * @Title("MC-37121: Deleted Category not shown as available on Product page")
 * @Description("Deleted category not shown as available Category on Product edit page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeletedCategoryNotShownAsAvailableOnProductPageTest.xml<br>")
 * @TestCaseId("MC-37121")
 * @group Catalog
 */
class AdminDeletedCategoryNotShownAsAvailableOnProductPageTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [logInAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogInAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogInAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogInAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogInAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogInAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogInAsAdmin
		$I->comment("Exiting Action Group [logInAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Delete categories"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeletedCategoryNotShownAsAvailableOnProductPageTest(AcceptanceTester $I)
	{
		$I->comment("Create Category");
		$I->comment("Entering Action Group [goToCreateCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageGoToCreateCategoryPage
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageGoToCreateCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateCategoryPage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddCategoryGoToCreateCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddCategoryGoToCreateCategoryPageWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToCreateCategoryPage
		$I->comment("Exiting Action Group [goToCreateCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->comment("Entering Action Group [fillCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "additional"); // stepKey: enterCategoryNameFillCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillCategoryForm
		$I->fillField("input[name='url_key']", ""); // stepKey: enterURLKeyFillCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillCategoryForm
		$I->comment("Exiting Action Group [fillCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->comment("Check if Category present on Product page");
		$I->comment("Entering Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(60); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [checkExistCategoryInList] AdminProductFormCategoryExistInCategoryListActionGroup");
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDownCheckExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownCheckExistCategoryInListWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: fillSearchCategoryCheckExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: fillSearchCategoryCheckExistCategoryInListWaitForPageLoad
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: seeCategoryCheckExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: seeCategoryCheckExistCategoryInListWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneAdvancedCategorySelectCheckExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: clickOnDoneAdvancedCategorySelectCheckExistCategoryInListWaitForPageLoad
		$I->comment("Exiting Action Group [checkExistCategoryInList] AdminProductFormCategoryExistInCategoryListActionGroup");
		$I->comment("Delete Category");
		$I->comment("Entering Action Group [deleteAdditionalCategory] AdminDeleteCategoryByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteAdditionalCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteAdditionalCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'additional')]", false); // stepKey: expandCategoriesDeleteAdditionalCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesDeleteAdditionalCategoryWaitForPageLoad
		$I->click("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'additional')]"); // stepKey: clickCategoryDeleteAdditionalCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryDeleteAdditionalCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteAdditionalCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteAdditionalCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteAdditionalCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteAdditionalCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteAdditionalCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteAdditionalCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteAdditionalCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'additional')]", false); // stepKey: expandCategoriesToSeeAllDeleteAdditionalCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesToSeeAllDeleteAdditionalCategoryWaitForPageLoad
		$I->dontSee("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'additional')]"); // stepKey: dontSeeCategoryDeleteAdditionalCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryDeleteAdditionalCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAdditionalCategory] AdminDeleteCategoryByNameActionGroup");
		$I->comment("Check if Category absent on Product page");
		$I->comment("Entering Action Group [navigateToProductPageAfterDelete] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductNavigateToProductPageAfterDelete
		$I->comment("Exiting Action Group [navigateToProductPageAfterDelete] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(60); // stepKey: waitForProductPageLoadAfterDelete
		$I->comment("Entering Action Group [checkNotExistCategoryInList] AdminProductFormCategoryNotExistInCategoryListActionGroup");
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDownCheckNotExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownCheckNotExistCategoryInListWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", "additional"); // stepKey: fillSearchCategoryCheckNotExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: fillSearchCategoryCheckNotExistCategoryInListWaitForPageLoad
		$I->dontSee("additional", "//*[@data-index='category_ids']//label[contains(., 'additional')]"); // stepKey: seeCategoryCheckNotExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: seeCategoryCheckNotExistCategoryInListWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneAdvancedCategorySelectCheckNotExistCategoryInList
		$I->waitForPageLoad(30); // stepKey: clickOnDoneAdvancedCategorySelectCheckNotExistCategoryInListWaitForPageLoad
		$I->comment("Exiting Action Group [checkNotExistCategoryInList] AdminProductFormCategoryNotExistInCategoryListActionGroup");
	}
}
