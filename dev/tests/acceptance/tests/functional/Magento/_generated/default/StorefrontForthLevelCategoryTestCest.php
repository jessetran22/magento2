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
 * @Title("[NO TESTCASEID]: Storefront forth level category test")
 * @Description("When the submenu was created in the third stage follow, the submenu works<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontForthLevelCategoryTest.xml<br>")
 * @group Catalog
 */
class StorefrontForthLevelCategoryTestCest
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
		$I->createEntity("category1", "hook", "SimpleSubCategory", [], []); // stepKey: category1
		$I->createEntity("category2", "hook", "SubCategoryWithParent", ["category1"], []); // stepKey: category2
		$I->createEntity("category3", "hook", "SubCategoryWithParent", ["category2"], []); // stepKey: category3
		$I->createEntity("category4", "hook", "SubCategoryWithParent", ["category3"], []); // stepKey: category4
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category4", "hook"); // stepKey: deleteCategory4
		$I->deleteEntity("category3", "hook"); // stepKey: deleteCategory3
		$I->deleteEntity("category2", "hook"); // stepKey: deleteCategory2
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory1
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
	 * @Features({"Catalog"})
	 * @Stories({"Category"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontForthLevelCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStorefrontPage
		$I->comment("Exiting Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('category1', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelOne
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelOneWaitForPageLoad
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('category2', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelTwo
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelTwoWaitForPageLoad
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('category3', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelThree
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelThreeWaitForPageLoad
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('category4', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelFour
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelFourWaitForPageLoad
	}
}
