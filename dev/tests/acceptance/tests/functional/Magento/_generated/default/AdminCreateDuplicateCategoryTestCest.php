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
 * @Title("MC-14702: Create Duplicate Category With Already Existed UrlKey")
 * @Description("Login as admin and create duplicate category<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateDuplicateCategoryTest.xml<br>")
 * @TestCaseId("MC-14702")
 * @group mtf_migrated
 */
class AdminCreateDuplicateCategoryTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Create category"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDuplicateCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Open Category Page and select Add category");
		$I->comment("Entering Action Group [goToCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageGoToCategoryPage
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCategoryPage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddCategoryGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddCategoryGoToCategoryPageWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->comment("Fill the Category form with same name and urlKey as initially created category(SimpleSubCategory)");
		$I->comment("Entering Action Group [fillCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->fillField("input[name='name']", $I->retrieveEntityField('category', 'name', 'test')); // stepKey: enterCategoryNameFillCategoryForm
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: scrollToSearchEngineOptimizationFillCategoryForm
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimizationFillCategoryFormWaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFillCategoryForm
		$I->fillField("input[name='url_key']", $I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test')); // stepKey: enterURLKeyFillCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfPageFillCategoryForm
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryFillCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategoryFillCategoryFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1FillCategoryForm
		$I->comment("Exiting Action Group [fillCategoryForm] FillCategoryNameAndUrlKeyAndSaveActionGroup");
		$I->comment("Assert error message");
		$I->see("The value specified in the URL Key field would generate a URL that already exists.", "//div[@class='message message-error error']"); // stepKey: seeErrorMessage
	}
}
