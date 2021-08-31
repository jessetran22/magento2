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
 * @Title("[NO TESTCASEID]: Add parent and child categories via API")
 * @Description("Login as admin, create parent and child categories via API.                 Check category level for child category entity based on parent level.                 Check category tree: parent element has child element.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckNewCategoryLevelAddedViaApiTest.xml<br>")
 * @group catalog
 */
class AdminCheckNewCategoryLevelAddedViaApiTestCest
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
		$I->createEntity("createCategoryWithChildrenBlank", "hook", "ApiCategoryWithChildren", [], []); // stepKey: createCategoryWithChildrenBlank
		$I->createEntity("createSubCategoryWithLevelZero", "hook", "ApiSubCategoryWithLevelZero", ["createCategoryWithChildrenBlank"], []); // stepKey: createSubCategoryWithLevelZero
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategoryWithChildrenBlank", "hook"); // stepKey: deleteCategoryWithChildrenBlank
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
	 * @Stories({"Add parent and child categories via API"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckNewCategoryLevelAddedViaApiTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [assertCategoryLevelByParentCategory] AssertAdminCategoryLevelByParentCategoryLevelActionGroup");
		$I->assertEquals($I->retrieveEntityField('createCategoryWithChildrenBlank', 'level', 'test') + 1, $I->retrieveEntityField('createSubCategoryWithLevelZero', 'level', 'test'), "wrongCategoryLevel"); // stepKey: compareCategoryLevelAssertCategoryLevelByParentCategory
		$I->comment("Exiting Action Group [assertCategoryLevelByParentCategory] AssertAdminCategoryLevelByParentCategoryLevelActionGroup");
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [expandCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeExpandCategoryTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadExpandCategoryTree
		$I->comment("Exiting Action Group [expandCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->comment("Entering Action Group [assertParentChildCategoryTreeElements] AdminAssertParentChildCategoryTreeElementsActionGroup");
		$I->seeElement("//li/ul/li[@class='x-tree-node']/div/a/span[contains(text(), '" . $I->retrieveEntityField('createCategoryWithChildrenBlank', 'name', 'test') . "')]/../../../ul/li[@class='x-tree-node']/div/a/span[contains(text(), '" . $I->retrieveEntityField('createSubCategoryWithLevelZero', 'name', 'test') . "')]"); // stepKey: seeSubcategoryIsUnderParentAssertParentChildCategoryTreeElements
		$I->comment("Exiting Action Group [assertParentChildCategoryTreeElements] AdminAssertParentChildCategoryTreeElementsActionGroup");
	}
}
