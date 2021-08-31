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
 * @Title("MAGETWO-94333: Mobile view page footer should stick to the bottom of page on Store front")
 * @Description("Mobile view page footer should stick to the bottom of page on Store front<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/StoreFrontMobileViewValidationTest.xml<br>")
 * @TestCaseId("MAGETWO-94333")
 * @group Cms
 */
class StoreFrontMobileViewValidationTestCest
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
		$I->createEntity("createPreReqCMSPage", "hook", "_longContentCmsPage", [], []); // stepKey: createPreReqCMSPage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createPreReqCMSPage", "hook"); // stepKey: deletePreReqCMSPage
		$I->resizeWindow(1280, 1024); // stepKey: resizeWindowToDesktop
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
	 * @Features({"Cms"})
	 * @Stories({"Mobile view page footer should stick to the bottom of page on Store front"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontMobileViewValidationTest(AcceptanceTester $I)
	{
		$I->resizeWindow(375, 812); // stepKey: resizeWindowToMobile
		$I->amOnPage($I->retrieveEntityField('createPreReqCMSPage', 'identifier', 'test')); // stepKey: amOnPageTestPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad6
		$I->comment("Verifying that Footer is not in visible area by default as the CMS page has lots of content which will occupy entire visible area");
		$topOfFooter = $I->executeJS("return document.querySelector('footer.page-footer').getBoundingClientRect().top"); // stepKey: topOfFooter
		$I->assertGreaterThan("812", $topOfFooter); // stepKey: assertDefaultLoad
		$I->comment("Verifying that even after scroll footer section is below the main content section");
		$I->scrollTo("footer.page-footer"); // stepKey: scrollToFooterSection
		$topOfTheFooterAfterScroll = $I->executeJS("return document.querySelector('footer.page-footer').getBoundingClientRect().top"); // stepKey: topOfTheFooterAfterScroll
		$bottomOfMainContent = $I->executeJS("return document.querySelector('#maincontent').getBoundingClientRect().bottom"); // stepKey: bottomOfMainContent
		$I->assertGreaterThan($bottomOfMainContent, $topOfTheFooterAfterScroll); // stepKey: assertAfterScroll
	}
}
