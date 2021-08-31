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
 * @Title("MAGETWO-94210: Verify that Number of Products per page retained when visiting a different category")
 * @Description("Verify that Number of Products per page retained when visiting a different category<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontRememberCategoryPaginationTest.xml<br>")
 * @TestCaseId("MAGETWO-94210")
 * @group Catalog
 */
class StorefrontRememberCategoryPaginationTestCest
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
		$I->createEntity("defaultCategory1", "hook", "_defaultCategory", [], []); // stepKey: defaultCategory1
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct", ["defaultCategory1"], []); // stepKey: simpleProduct1
		$I->createEntity("defaultCategory2", "hook", "_defaultCategory", [], []); // stepKey: defaultCategory2
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct", ["defaultCategory2"], []); // stepKey: simpleProduct2
		$I->createEntity("setRememberPaginationCatalogStorefrontConfig", "hook", "RememberPaginationCatalogStorefrontConfig", [], []); // stepKey: setRememberPaginationCatalogStorefrontConfig
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->createEntity("setDefaultCatalogStorefrontConfiguration", "hook", "DefaultCatalogStorefrontConfiguration", [], []); // stepKey: setDefaultCatalogStorefrontConfiguration
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("defaultCategory1", "hook"); // stepKey: deleteCategory1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("defaultCategory2", "hook"); // stepKey: deleteCategory2
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"MAGETWO-61478: Number of Products displayed per page not retained when visiting a different category"})
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontRememberCategoryPaginationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [GoToStorefrontCategory1Page] GoToStorefrontCategoryPageByParametersActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('defaultCategory1', 'custom_attributes[url_key]', 'test') . ".html?product_list_limit=12&product_list_mode=grid&product_list_order=position&product_list_dir=asc"); // stepKey: onCategoryPageGoToStorefrontCategory1Page
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToStorefrontCategory1Page
		$I->comment("Exiting Action Group [GoToStorefrontCategory1Page] GoToStorefrontCategoryPageByParametersActionGroup");
		$I->comment("Entering Action Group [verifyCategory1PageParameters] VerifyCategoryPageParametersActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('defaultCategory1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlVerifyCategory1PageParameters
		$I->seeInTitle($I->retrieveEntityField('defaultCategory1', 'name', 'test')); // stepKey: assertCategoryNameInTitleVerifyCategory1PageParameters
		$I->see($I->retrieveEntityField('defaultCategory1', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameVerifyCategory1PageParameters
		$I->see("grid", "//*[@id='authenticationPopup']/following-sibling::div[1]//*[@class='modes']/strong[@class='modes-mode active mode-grid']/span"); // stepKey: assertViewModeVerifyCategory1PageParameters
		$I->see("12", "//*[@id='authenticationPopup']/following-sibling::div[3]//*[@id='limiter']"); // stepKey: assertNumberOfProductsPerPageVerifyCategory1PageParameters
		$I->see("position", "//*[@id='authenticationPopup']/following-sibling::div[1]//*[@id='sorter']"); // stepKey: assertSortedByVerifyCategory1PageParameters
		$I->comment("Exiting Action Group [verifyCategory1PageParameters] VerifyCategoryPageParametersActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('defaultCategory2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategory2Page
		$I->waitForPageLoad(30); // stepKey: waitForCategory2PageToLoad
		$I->comment("Entering Action Group [verifyCategory2PageParameters] VerifyCategoryPageParametersActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('defaultCategory2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlVerifyCategory2PageParameters
		$I->seeInTitle($I->retrieveEntityField('defaultCategory2', 'name', 'test')); // stepKey: assertCategoryNameInTitleVerifyCategory2PageParameters
		$I->see($I->retrieveEntityField('defaultCategory2', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameVerifyCategory2PageParameters
		$I->see("grid", "//*[@id='authenticationPopup']/following-sibling::div[1]//*[@class='modes']/strong[@class='modes-mode active mode-grid']/span"); // stepKey: assertViewModeVerifyCategory2PageParameters
		$I->see("12", "//*[@id='authenticationPopup']/following-sibling::div[3]//*[@id='limiter']"); // stepKey: assertNumberOfProductsPerPageVerifyCategory2PageParameters
		$I->see("position", "//*[@id='authenticationPopup']/following-sibling::div[1]//*[@id='sorter']"); // stepKey: assertSortedByVerifyCategory2PageParameters
		$I->comment("Exiting Action Group [verifyCategory2PageParameters] VerifyCategoryPageParametersActionGroup");
	}
}
