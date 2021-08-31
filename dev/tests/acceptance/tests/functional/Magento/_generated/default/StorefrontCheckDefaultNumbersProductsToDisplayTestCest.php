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
 * @Title("MC-17386: Check default numbers: products to display")
 * @Description("Check default numbers: products to display<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontCheckDefaultNumberProductsToDisplayTest.xml<br>")
 * @TestCaseId("MC-17386")
 * @group catalog
 */
class StorefrontCheckDefaultNumbersProductsToDisplayTestCest
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
		$I->comment("Login as Admin");
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create 37 Products and Subcategory");
		$I->comment("Create 37 Products and Subcategory");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProductOne", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductOne
		$I->createEntity("createSimpleProductTwo", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwo
		$I->createEntity("createSimpleProductThree", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThree
		$I->createEntity("createSimpleProductFour", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductFour
		$I->createEntity("createSimpleProductFive", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductFive
		$I->createEntity("createSimpleProductSix", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductSix
		$I->createEntity("createSimpleProductSeven", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductSeven
		$I->createEntity("createSimpleProductEight", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductEight
		$I->createEntity("createSimpleProductNine", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductNine
		$I->createEntity("createSimpleProductTen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTen
		$I->createEntity("createSimpleProductEleven", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductEleven
		$I->createEntity("createSimpleProductTwelve", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwelve
		$I->createEntity("createSimpleProductThirteen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirteen
		$I->createEntity("createSimpleProductFourteen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductFourteen
		$I->createEntity("createSimpleProductFifteen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductFifteen
		$I->createEntity("createSimpleProductSixteen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductSixteen
		$I->createEntity("createSimpleProductSeventeen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductSeventeen
		$I->createEntity("createSimpleProductEighteen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductEighteen
		$I->createEntity("createSimpleProductNineteen", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductNineteen
		$I->createEntity("createSimpleProductTwenty", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwenty
		$I->createEntity("createSimpleProductTwentyOne", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentyOne
		$I->createEntity("createSimpleProductTwentyTwo", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentyTwo
		$I->createEntity("createSimpleProductTwentyThree", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentyThree
		$I->createEntity("createSimpleProductTwentyFour", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentyFour
		$I->createEntity("createSimpleProductTwentyFive", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentyFive
		$I->createEntity("createSimpleProductTwentySix", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentySix
		$I->createEntity("createSimpleProductTwentySeven", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentySeven
		$I->createEntity("createSimpleProductTwentyEight", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentyEight
		$I->createEntity("createSimpleProductTwentyNine", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductTwentyNine
		$I->createEntity("createSimpleProductThirty", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirty
		$I->createEntity("createSimpleProductThirtyOne", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirtyOne
		$I->createEntity("createSimpleProductThirtyTwo", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirtyTwo
		$I->createEntity("createSimpleProductThirtyThree", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirtyThree
		$I->createEntity("createSimpleProductThirtyFour", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirtyFour
		$I->createEntity("createSimpleProductThirtyFive", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirtyFive
		$I->createEntity("createSimpleProductThirtySix", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirtySix
		$I->createEntity("createSimpleProductThirtySeven", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProductThirtySeven
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProductOne", "hook"); // stepKey: deleteProductOne
		$I->deleteEntity("createSimpleProductTwo", "hook"); // stepKey: deleteProductTwo
		$I->deleteEntity("createSimpleProductThree", "hook"); // stepKey: deleteProductThree
		$I->deleteEntity("createSimpleProductFour", "hook"); // stepKey: deleteProductFour
		$I->deleteEntity("createSimpleProductFive", "hook"); // stepKey: deleteProductFive
		$I->deleteEntity("createSimpleProductSix", "hook"); // stepKey: deleteProductSix
		$I->deleteEntity("createSimpleProductSeven", "hook"); // stepKey: deleteProductSeven
		$I->deleteEntity("createSimpleProductEight", "hook"); // stepKey: deleteProductEight
		$I->deleteEntity("createSimpleProductNine", "hook"); // stepKey: deleteProductNine
		$I->deleteEntity("createSimpleProductTen", "hook"); // stepKey: deleteProductTen
		$I->deleteEntity("createSimpleProductEleven", "hook"); // stepKey: deleteProductEleven
		$I->deleteEntity("createSimpleProductTwelve", "hook"); // stepKey: deleteProductTwelve
		$I->deleteEntity("createSimpleProductThirteen", "hook"); // stepKey: deleteProductThirteen
		$I->deleteEntity("createSimpleProductFourteen", "hook"); // stepKey: deleteProductFourteen
		$I->deleteEntity("createSimpleProductFifteen", "hook"); // stepKey: deleteProductFifteen
		$I->deleteEntity("createSimpleProductSixteen", "hook"); // stepKey: deleteProductSixteen
		$I->deleteEntity("createSimpleProductSeventeen", "hook"); // stepKey: deleteProductSeventeen
		$I->deleteEntity("createSimpleProductEighteen", "hook"); // stepKey: deleteProductEighteen
		$I->deleteEntity("createSimpleProductNineteen", "hook"); // stepKey: deleteProductNineteen
		$I->deleteEntity("createSimpleProductTwenty", "hook"); // stepKey: deleteProductTwenty
		$I->deleteEntity("createSimpleProductTwentyOne", "hook"); // stepKey: deleteProductTwentyOne
		$I->deleteEntity("createSimpleProductTwentyTwo", "hook"); // stepKey: deleteProductTwentyTwo
		$I->deleteEntity("createSimpleProductTwentyThree", "hook"); // stepKey: deleteProductTwentyThree
		$I->deleteEntity("createSimpleProductTwentyFour", "hook"); // stepKey: deleteProductTwentyFour
		$I->deleteEntity("createSimpleProductTwentyFive", "hook"); // stepKey: deleteProductTwentyFive
		$I->deleteEntity("createSimpleProductTwentySix", "hook"); // stepKey: deleteProductTwentySix
		$I->deleteEntity("createSimpleProductTwentySeven", "hook"); // stepKey: deleteProductTwentySeven
		$I->deleteEntity("createSimpleProductTwentyEight", "hook"); // stepKey: deleteProductTwentyEight
		$I->deleteEntity("createSimpleProductTwentyNine", "hook"); // stepKey: deleteProductTwentyNine
		$I->deleteEntity("createSimpleProductThirty", "hook"); // stepKey: deleteProductThirty
		$I->deleteEntity("createSimpleProductThirtyOne", "hook"); // stepKey: deleteProductThirtyOne
		$I->deleteEntity("createSimpleProductThirtyTwo", "hook"); // stepKey: deleteProductThirtyTwo
		$I->deleteEntity("createSimpleProductThirtyThree", "hook"); // stepKey: deleteProductThirtyThree
		$I->deleteEntity("createSimpleProductThirtyFour", "hook"); // stepKey: deleteProductThirtyFour
		$I->deleteEntity("createSimpleProductThirtyFive", "hook"); // stepKey: deleteProductThirtyFive
		$I->deleteEntity("createSimpleProductThirtySix", "hook"); // stepKey: deleteProductThirtySix
		$I->deleteEntity("createSimpleProductThirtySeven", "hook"); // stepKey: deleteProductThirtySeven
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
	 * @Stories({"Product grid"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckDefaultNumbersProductsToDisplayTest(AcceptanceTester $I)
	{
		$I->comment("Verify configuration for default number of products displayed in the grid view");
		$I->comment("Verify configuration for default number of products displayed in the grid view");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: goToCatalogConfigPagePage
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageLoad
		$I->conditionalClick("#catalog_frontend-head", "#catalog_frontend_grid_per_page_values", false); // stepKey: openCatalogConfigStorefrontSection
		$I->waitForElementVisible("#catalog_frontend_grid_per_page_values", 30); // stepKey: waitForSectionOpen
		$I->seeInField("#catalog_frontend_grid_per_page_values", "12,24,36"); // stepKey: seeDefaultValueAllowedNumberProductsPerPage
		$I->seeInField("#catalog_frontend_grid_per_page", "12"); // stepKey: seeDefaultValueProductPerPage
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Open storefront on the category page");
		$I->comment("Open storefront on the category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCreatedCategoryPage
		$I->comment("Check the drop-down at the bottom of page contains options");
		$I->comment("Check the drop-down at the bottom of page contains options");
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']"); // stepKey: scrollToBottomToolbarSection
		$I->assertElementContainsAttribute("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "value", "12"); // stepKey: assertPerPageFirstValue
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "24"); // stepKey: selectPerPageSecondValue
		$I->assertElementContainsAttribute("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "value", "24"); // stepKey: assertPerPageSecondValue
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "36"); // stepKey: selectPerPageThirdValue
		$I->assertElementContainsAttribute("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "value", "36"); // stepKey: assertPerPageThirdValue
	}
}
