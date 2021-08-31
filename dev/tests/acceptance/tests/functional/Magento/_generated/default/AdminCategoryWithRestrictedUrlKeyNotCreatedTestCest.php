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
 * @Title("MC-17515: Category with restricted Url Key cannot be created")
 * @Description("Category with restricted Url Key cannot be created<h3>Test files</h3>app/code/Magento/CatalogUrlRewrite/Test/Mftf/Test/AdminCategoryWithRestrictedUrlKeyNotCreatedTest.xml<br>")
 * @TestCaseId("MC-17515")
 * @group CatalogUrlRewrite
 */
class AdminCategoryWithRestrictedUrlKeyNotCreatedTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created categories");
		$I->comment("Delete created categories");
		$I->comment("Entering Action Group [deleteAdminCategory] AdminDeleteCategoryByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteAdminCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteAdminCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'admin')]", false); // stepKey: expandCategoriesDeleteAdminCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesDeleteAdminCategoryWaitForPageLoad
		$I->click("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'admin')]"); // stepKey: clickCategoryDeleteAdminCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryDeleteAdminCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteAdminCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteAdminCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteAdminCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteAdminCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteAdminCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteAdminCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteAdminCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'admin')]", false); // stepKey: expandCategoriesToSeeAllDeleteAdminCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesToSeeAllDeleteAdminCategoryWaitForPageLoad
		$I->dontSee("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'admin')]"); // stepKey: dontSeeCategoryDeleteAdminCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryDeleteAdminCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAdminCategory] AdminDeleteCategoryByNameActionGroup");
		$I->comment("Entering Action Group [deleteSoapCategory] AdminDeleteCategoryByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteSoapCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteSoapCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'soap')]", false); // stepKey: expandCategoriesDeleteSoapCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesDeleteSoapCategoryWaitForPageLoad
		$I->click("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'soap')]"); // stepKey: clickCategoryDeleteSoapCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryDeleteSoapCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteSoapCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteSoapCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteSoapCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteSoapCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteSoapCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteSoapCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteSoapCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'soap')]", false); // stepKey: expandCategoriesToSeeAllDeleteSoapCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesToSeeAllDeleteSoapCategoryWaitForPageLoad
		$I->dontSee("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'soap')]"); // stepKey: dontSeeCategoryDeleteSoapCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryDeleteSoapCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSoapCategory] AdminDeleteCategoryByNameActionGroup");
		$I->comment("Entering Action Group [deleteRestCategory] AdminDeleteCategoryByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteRestCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteRestCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'rest')]", false); // stepKey: expandCategoriesDeleteRestCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesDeleteRestCategoryWaitForPageLoad
		$I->click("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'rest')]"); // stepKey: clickCategoryDeleteRestCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryDeleteRestCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteRestCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteRestCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteRestCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteRestCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteRestCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteRestCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteRestCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'rest')]", false); // stepKey: expandCategoriesToSeeAllDeleteRestCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesToSeeAllDeleteRestCategoryWaitForPageLoad
		$I->dontSee("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'rest')]"); // stepKey: dontSeeCategoryDeleteRestCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryDeleteRestCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteRestCategory] AdminDeleteCategoryByNameActionGroup");
		$I->comment("Entering Action Group [deleteGraphQlCategory] AdminDeleteCategoryByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteGraphQlCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteGraphQlCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'graphql')]", false); // stepKey: expandCategoriesDeleteGraphQlCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesDeleteGraphQlCategoryWaitForPageLoad
		$I->click("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'graphql')]"); // stepKey: clickCategoryDeleteGraphQlCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryDeleteGraphQlCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteGraphQlCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteGraphQlCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteGraphQlCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteGraphQlCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteGraphQlCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteGraphQlCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteGraphQlCategory
		$I->conditionalClick(".tree-actions a:last-child", "//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'graphql')]", false); // stepKey: expandCategoriesToSeeAllDeleteGraphQlCategory
		$I->waitForPageLoad(30); // stepKey: expandCategoriesToSeeAllDeleteGraphQlCategoryWaitForPageLoad
		$I->dontSee("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'graphql')]"); // stepKey: dontSeeCategoryDeleteGraphQlCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryDeleteGraphQlCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteGraphQlCategory] AdminDeleteCategoryByNameActionGroup");
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
	 * @Features({"CatalogUrlRewrite"})
	 * @Stories({"Url rewrites"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCategoryWithRestrictedUrlKeyNotCreatedTest(AcceptanceTester $I)
	{
		$I->comment("Check category creation with restricted url key 'admin'");
		$I->comment("Check category creation with restricted url key 'admin'");
		$I->comment("Entering Action Group [goToCreateAdminCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageGoToCreateAdminCategoryPage
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageGoToCreateAdminCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateAdminCategoryPage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddCategoryGoToCreateAdminCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddCategoryGoToCreateAdminCategoryPageWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToCreateAdminCategoryPage
		$I->comment("Exiting Action Group [goToCreateAdminCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->comment("Entering Action Group [fillAdminFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "admin"); // stepKey: enterCategoryNameFillAdminFirstCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillAdminFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillAdminFirstCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillAdminFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillAdminFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillAdminFirstCategoryForm
		$I->fillField("input[name='url_key']", ""); // stepKey: enterURLKeyFillAdminFirstCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillAdminFirstCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillAdminFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillAdminFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillAdminFirstCategoryForm
		$I->comment("Exiting Action Group [fillAdminFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"admin\" matches a reserved endpoint name (admin). Use another URL key.", "#messages div.message-error"); // stepKey: seeAdminFirstErrorMessage
		$I->comment("Entering Action Group [fillAdminSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryNameFillAdminSecondCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillAdminSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillAdminSecondCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillAdminSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillAdminSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillAdminSecondCategoryForm
		$I->fillField("input[name='url_key']", "admin"); // stepKey: enterURLKeyFillAdminSecondCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillAdminSecondCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillAdminSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillAdminSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillAdminSecondCategoryForm
		$I->comment("Exiting Action Group [fillAdminSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"admin\" matches a reserved endpoint name (admin). Use another URL key.", "#messages div.message-error"); // stepKey: seeAdminSecondErrorMessage
		$I->comment("Create category with 'admin' name");
		$I->comment("Create category with 'admin' name");
		$I->comment("Entering Action Group [fillAdminThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "admin"); // stepKey: enterCategoryNameFillAdminThirdCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillAdminThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillAdminThirdCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillAdminThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillAdminThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillAdminThirdCategoryForm
		$I->fillField("input[name='url_key']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterURLKeyFillAdminThirdCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillAdminThirdCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillAdminThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillAdminThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillAdminThirdCategoryForm
		$I->comment("Exiting Action Group [fillAdminThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->comment("Entering Action Group [seeAdminSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementSeeAdminSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageSeeAdminSuccessMessage
		$I->comment("Exiting Action Group [seeAdminSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->seeElement("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'admin')]"); // stepKey: seeAdminCategoryInTree
		$I->waitForPageLoad(30); // stepKey: seeAdminCategoryInTreeWaitForPageLoad
		$I->comment("Check category creation with restricted url key 'soap'");
		$I->comment("Check category creation with restricted url key 'soap'");
		$I->comment("Entering Action Group [goToCreateSoapCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageGoToCreateSoapCategoryPage
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageGoToCreateSoapCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateSoapCategoryPage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddCategoryGoToCreateSoapCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddCategoryGoToCreateSoapCategoryPageWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToCreateSoapCategoryPage
		$I->comment("Exiting Action Group [goToCreateSoapCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->comment("Entering Action Group [fillSoapFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "soap"); // stepKey: enterCategoryNameFillSoapFirstCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillSoapFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillSoapFirstCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillSoapFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillSoapFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillSoapFirstCategoryForm
		$I->fillField("input[name='url_key']", ""); // stepKey: enterURLKeyFillSoapFirstCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillSoapFirstCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillSoapFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillSoapFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillSoapFirstCategoryForm
		$I->comment("Exiting Action Group [fillSoapFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"soap\" matches a reserved endpoint name (admin, soap, rest, graphql, standard). Use another URL key.", "#messages div.message-error"); // stepKey: seeSoapFirstErrorMessage
		$I->comment("Entering Action Group [fillSoapSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "ApiCategory" . msq("ApiCategory")); // stepKey: enterCategoryNameFillSoapSecondCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillSoapSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillSoapSecondCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillSoapSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillSoapSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillSoapSecondCategoryForm
		$I->fillField("input[name='url_key']", "soap"); // stepKey: enterURLKeyFillSoapSecondCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillSoapSecondCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillSoapSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillSoapSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillSoapSecondCategoryForm
		$I->comment("Exiting Action Group [fillSoapSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"soap\" matches a reserved endpoint name (admin, soap, rest, graphql, standard). Use another URL key.", "#messages div.message-error"); // stepKey: seeSoapSecondErrorMessage
		$I->comment("Create category with 'soap' name");
		$I->comment("Create category with 'soap' name");
		$I->comment("Entering Action Group [fillSoapThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "soap"); // stepKey: enterCategoryNameFillSoapThirdCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillSoapThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillSoapThirdCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillSoapThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillSoapThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillSoapThirdCategoryForm
		$I->fillField("input[name='url_key']", "ApiCategory" . msq("ApiCategory")); // stepKey: enterURLKeyFillSoapThirdCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillSoapThirdCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillSoapThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillSoapThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillSoapThirdCategoryForm
		$I->comment("Exiting Action Group [fillSoapThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->comment("Entering Action Group [seeSoapSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementSeeSoapSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageSeeSoapSuccessMessage
		$I->comment("Exiting Action Group [seeSoapSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->seeElement("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'soap')]"); // stepKey: seeSoapCategoryInTree
		$I->waitForPageLoad(30); // stepKey: seeSoapCategoryInTreeWaitForPageLoad
		$I->comment("Check category creation with restricted url key 'rest'");
		$I->comment("Check category creation with restricted url key 'rest'");
		$I->comment("Entering Action Group [goToCreateRestCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageGoToCreateRestCategoryPage
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageGoToCreateRestCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateRestCategoryPage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddCategoryGoToCreateRestCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddCategoryGoToCreateRestCategoryPageWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToCreateRestCategoryPage
		$I->comment("Exiting Action Group [goToCreateRestCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->comment("Entering Action Group [fillRestFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "rest"); // stepKey: enterCategoryNameFillRestFirstCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillRestFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillRestFirstCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillRestFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillRestFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillRestFirstCategoryForm
		$I->fillField("input[name='url_key']", ""); // stepKey: enterURLKeyFillRestFirstCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillRestFirstCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillRestFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillRestFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillRestFirstCategoryForm
		$I->comment("Exiting Action Group [fillRestFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"rest\" matches a reserved endpoint name (admin, soap, rest, graphql, standard). Use another URL key.", "#messages div.message-error"); // stepKey: seeRestFirstErrorMessage
		$I->comment("Entering Action Group [fillRestSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "subCategory" . msq("SubCategoryWithParent")); // stepKey: enterCategoryNameFillRestSecondCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillRestSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillRestSecondCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillRestSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillRestSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillRestSecondCategoryForm
		$I->fillField("input[name='url_key']", "rest"); // stepKey: enterURLKeyFillRestSecondCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillRestSecondCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillRestSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillRestSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillRestSecondCategoryForm
		$I->comment("Exiting Action Group [fillRestSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"rest\" matches a reserved endpoint name (admin, soap, rest, graphql, standard). Use another URL key.", "#messages div.message-error"); // stepKey: seeRestSecondErrorMessage
		$I->comment("Create category with 'rest' name");
		$I->comment("Create category with 'rest' name");
		$I->comment("Entering Action Group [fillRestThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "rest"); // stepKey: enterCategoryNameFillRestThirdCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillRestThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillRestThirdCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillRestThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillRestThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillRestThirdCategoryForm
		$I->fillField("input[name='url_key']", "subCategory" . msq("SubCategoryWithParent")); // stepKey: enterURLKeyFillRestThirdCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillRestThirdCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillRestThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillRestThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillRestThirdCategoryForm
		$I->comment("Exiting Action Group [fillRestThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->comment("Entering Action Group [seeRestSuccessMesdgssage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementSeeRestSuccessMesdgssage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageSeeRestSuccessMesdgssage
		$I->comment("Exiting Action Group [seeRestSuccessMesdgssage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->seeElement("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'rest')]"); // stepKey: seeRestCategoryInTree
		$I->waitForPageLoad(30); // stepKey: seeRestCategoryInTreeWaitForPageLoad
		$I->comment("Check category creation with restricted url key 'graphql'");
		$I->comment("Check category creation with restricted url key 'graphql'");
		$I->comment("Entering Action Group [goToCreateCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageGoToCreateCategoryPage
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageGoToCreateCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateCategoryPage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddCategoryGoToCreateCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddCategoryGoToCreateCategoryPageWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToCreateCategoryPage
		$I->comment("Exiting Action Group [goToCreateCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->comment("Entering Action Group [fillGraphQlFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "graphql"); // stepKey: enterCategoryNameFillGraphQlFirstCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillGraphQlFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillGraphQlFirstCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillGraphQlFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillGraphQlFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillGraphQlFirstCategoryForm
		$I->fillField("input[name='url_key']", ""); // stepKey: enterURLKeyFillGraphQlFirstCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillGraphQlFirstCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillGraphQlFirstCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillGraphQlFirstCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillGraphQlFirstCategoryForm
		$I->comment("Exiting Action Group [fillGraphQlFirstCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"graphql\" matches a reserved endpoint name (admin, soap, rest, graphql, standard). Use another URL key.", "#messages div.message-error"); // stepKey: seeGraphQlFirstErrorMessage
		$I->comment("Entering Action Group [fillGraphQlSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "subCategory" . msq("NewSubCategoryWithParent")); // stepKey: enterCategoryNameFillGraphQlSecondCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillGraphQlSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillGraphQlSecondCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillGraphQlSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillGraphQlSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillGraphQlSecondCategoryForm
		$I->fillField("input[name='url_key']", "graphql"); // stepKey: enterURLKeyFillGraphQlSecondCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillGraphQlSecondCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillGraphQlSecondCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillGraphQlSecondCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillGraphQlSecondCategoryForm
		$I->comment("Exiting Action Group [fillGraphQlSecondCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->see("URL key \"graphql\" matches a reserved endpoint name (admin, soap, rest, graphql, standard). Use another URL key.", "#messages div.message-error"); // stepKey: seeGraphQlSecondErrorMessage
		$I->comment("Create category with 'graphql' name");
		$I->comment("Create category with 'graphql' name");
		$I->comment("Entering Action Group [fillGraphQlThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", "graphql"); // stepKey: enterCategoryNameFillGraphQlThirdCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillGraphQlThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillGraphQlThirdCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillGraphQlThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillGraphQlThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillGraphQlThirdCategoryForm
		$I->fillField("input[name='url_key']", "subCategory" . msq("NewSubCategoryWithParent")); // stepKey: enterURLKeyFillGraphQlThirdCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillGraphQlThirdCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillGraphQlThirdCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillGraphQlThirdCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillGraphQlThirdCategoryForm
		$I->comment("Exiting Action Group [fillGraphQlThirdCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->comment("Entering Action Group [seeGraphQlSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementSeeGraphQlSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageSeeGraphQlSuccessMessage
		$I->comment("Exiting Action Group [seeGraphQlSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->seeElement("//div[contains(@class, 'categories-side-col')]//a/span[contains(text(), 'graphql')]"); // stepKey: seeGraphQlCategoryInTree
		$I->waitForPageLoad(30); // stepKey: seeGraphQlCategoryInTreeWaitForPageLoad
	}
}
